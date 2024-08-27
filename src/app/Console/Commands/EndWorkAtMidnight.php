<?php

namespace App\Console\Commands;

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Work;
use Illuminate\Support\Facades\Log;

class EndWorkAtMidnight extends Command
{
    protected $signature = 'work:end-midnight';
    protected $description = 'End work if not finished by midnight';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = now()->toDateString();

        $works = Work::whereDate('start_time', $today)
            ->whereNull('end_time')
            ->get();

        foreach ($works as $work) {
            $work->end_time = now();
            $work->save();

            Log::info('Auto-ended work for user ID: ' . $work->user_id);
        }

        $this->info('Work end check completed');
    }
}
