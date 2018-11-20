<?php

namespace App\Console;

use App\Http\Controllers\Admin\WeChat\V1\Models\WeekRanking;
use App\Jobs\ActivePlayerJob;
use App\Jobs\CharacterJob;
use App\Jobs\MauJob;
use App\Jobs\WeekRankingJob;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }


}
