<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import the Log facade
use App\Services\TeamBonusService;
use App\Http\Controllers\scriptController;
use App\Models\usersModel;


class aipfTeamBonusLevelRelease extends Command
{
    protected $signature = 'teambonus:release';
    protected $description = 'Run TeamBonusService::distributeBonus';

    public function handle(TeamBonusService $svc)
    {
        $logger = Log::channel('level_check'); // Use the custom channel

        $logger->info('--- TeamBonus Level Check Started ---');

        try {
            $appHome = new scriptController;
            $appHome->starBonus();
           // $svc->distributeBonus();
            $logger->info('distributeBonus() executed successfully.');

            $this->info('TeamBonus distribution completed successfully.');

        } 
        catch (\Throwable $e) 
        {
            $logger->error('Error during TeamBonus Level Check or Distribute Bonus : ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
        }


        // $svc->checkLevel();

        // $this->info('Check level excuted.');

        // $svc->distributeBonus();

        // $this->info('Teambonus distribution completed successfully.');

        // $this->info($res);
    }
}
