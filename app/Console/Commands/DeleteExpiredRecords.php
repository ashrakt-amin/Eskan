<?php

namespace App\Console\Commands;

use App\Models\CityCenterUsers;
use App\Models\ContactUs;
use App\Models\Owner;
use App\Models\Reservation;
use App\Models\SeekMoney;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteExpiredRecords extends Command
{
    protected $signature = 'records:delete-expired';
    protected $description = 'Delete expired records from the archive table.';

    public function handle()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        CityCenterUsers::onlyTrashed()
            ->where('deleted_at', '<', $thirtyDaysAgo)
            ->forceDelete();

        ContactUs::onlyTrashed()
            ->where('deleted_at', '<', $thirtyDaysAgo)
            ->forceDelete();

        Owner::onlyTrashed()
            ->where('deleted_at', '<', $thirtyDaysAgo)
            ->forceDelete();

        Reservation::onlyTrashed()
            ->where('deleted_at', '<', $thirtyDaysAgo)
            ->forceDelete();

        SeekMoney::onlyTrashed()
            ->where('deleted_at', '<', $thirtyDaysAgo)
            ->forceDelete();

        Wallet::onlyTrashed()
            ->where('deleted_at', '<', $thirtyDaysAgo)
            ->forceDelete();

        $this->info('Expired records deleted successfully.');
    }
}
