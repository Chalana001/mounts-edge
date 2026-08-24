<?php

namespace App\Console\Commands;

use App\Models\Enquiry;
use Illuminate\Console\Command;

class ArchiveExpiredEnquiries extends Command
{
    protected $signature = 'enquiries:archive-expired';

    protected $description = 'Move enquiries older than twelve months to Trash';

    public function handle(): int
    {
        $count = Enquiry::where('created_at', '<', now()->subMonths(12))->delete();

        $this->info("Archived {$count} expired enquiries.");

        return self::SUCCESS;
    }
}
