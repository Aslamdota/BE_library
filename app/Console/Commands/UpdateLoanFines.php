<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use App\Models\FineMaster;
use Carbon\Carbon;

class UpdateLoanFines extends Command
{
    protected $signature = 'loans:update-fines';
    protected $description = 'Update fines for overdue loans';

    public function handle()
    {
        $now = Carbon::now();
        $fineSetting = FineMaster::where('status', 'active')->first();

        if (!$fineSetting) {
            $this->error('No active fine configuration found.');
            return;
        }

        $gracePeriod = $fineSetting->grace_period;
        $finePerDay = $fineSetting->fine_amount;

        $overdueLoans = Loan::whereNotIn('status', ['returned', 'rejected'])
            ->whereDate('due_date', '<', $now->copy()->subDays($gracePeriod))
            ->get();

        foreach ($overdueLoans as $loan) {
            $daysLate = $loan->due_date->diffInDays($now->copy()->subDays($gracePeriod));
            $fineAmount = $daysLate * $finePerDay;

            $loan->update(['fine' => $fineAmount]);
        }

        $this->info('Fines updated for overdue loans.');
    }
}
