<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminEnquiryController extends Controller
{
    public function index(): View
    {
        return view('admin.enquiries.index', [
            'enquiries' => Enquiry::orderByRaw("CASE WHEN status = 'new' THEN 0 ELSE 1 END")
                ->latest()
                ->paginate(12),
        ]);
    }

    public function show(Enquiry $enquiry): View
    {
        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function updateStatus(Request $request, Enquiry $enquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Enquiry::STATUSES)],
        ]);

        $enquiry->update($validated);

        return back()->with('success', 'Enquiry status updated.');
    }

    public function destroy(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry moved to Trash.');
    }

    public function trash(): View
    {
        return view('admin.enquiries.trash', [
            'enquiries' => Enquiry::onlyTrashed()->latest('deleted_at')->paginate(12),
        ]);
    }

    public function restore(int $enquiry): RedirectResponse
    {
        Enquiry::onlyTrashed()->findOrFail($enquiry)->restore();

        return back()->with('success', 'Enquiry restored.');
    }

    public function forceDestroy(int $enquiry): RedirectResponse
    {
        Enquiry::onlyTrashed()->findOrFail($enquiry)->forceDelete();

        return back()->with('success', 'Enquiry permanently deleted.');
    }

    public function emptyTrash(Request $request): RedirectResponse
    {
        if (! Hash::check((string) $request->input('password'), $request->user()->password)) {
            throw ValidationException::withMessages(['password' => 'The password is incorrect.']);
        }

        Enquiry::onlyTrashed()->forceDelete();

        return back()->with('success', 'Trash emptied.');
    }
}
