<?php

namespace App\Http\Controllers\Concerns;

use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

trait HandlesImageUploads
{
    /**
     * Validation rules for a multi-image field backed by syncImages().
     */
    protected function imageRules(int $max = 5): array
    {
        return [
            'existing_images' => ['nullable', 'array'],
            'existing_images.*' => ['string'],
            'new_images' => ['nullable', 'array', 'max:'.$max],
            'new_images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    /**
     * Merge the images the admin kept with any newly uploaded ones, delete the
     * files that were dropped, and return the final ordered list.
     *
     * @param  array<int, string>  $current  paths the model owns right now
     * @return array<int, string>
     */
    protected function syncImages(Request $request, array $current, string $folder, int $max = 5): array
    {
        // Intersect with what the model actually owns: existing_images comes
        // from the client and must never be trusted to name arbitrary storage
        // paths. array_intersect keeps the submitted order, which is how the
        // admin's up/down reordering gets persisted.
        $kept = array_values(array_intersect(
            array_map('strval', (array) $request->input('existing_images', [])),
            $current
        ));

        $incoming = array_values(array_filter((array) $request->file('new_images', [])));

        // Check the counts before storing anything so a rejected submission
        // never leaves orphaned files on disk.
        if ($kept === [] && $incoming === []) {
            throw ValidationException::withMessages([
                'new_images' => 'Please add at least one image.',
            ]);
        }

        if (count($kept) + count($incoming) > $max) {
            throw ValidationException::withMessages([
                'new_images' => "You can upload a maximum of {$max} images.",
            ]);
        }

        $optimizer = app(ImageOptimizer::class);

        foreach ($incoming as $file) {
            $kept[] = '/storage/'.$optimizer->store($file, $folder, 'public');
        }

        $this->deletePublicImages(array_diff($current, $kept));

        return $kept;
    }

    protected function deletePublicImages(iterable $paths): void
    {
        foreach ($paths as $path) {
            $this->deletePublicImage($path);
        }
    }

    protected function deletePublicImage(?string $path): void
    {
        if (! $path || ! str_starts_with($path, '/storage/')) {
            return;
        }

        $relative = substr($path, strlen('/storage/'));

        // Drop the srcset variants first, while the original is still there to
        // derive their names from. Left behind, they would outlive the photo and
        // keep being served by any srcset that still lists them.
        if (Storage::disk('public')->exists($relative)) {
            app(ImageOptimizer::class)->forget(Storage::disk('public')->path($relative));
        }

        Storage::disk('public')->delete($relative);
    }
}
