<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import the Log facade
use App\Services\TeamBonusService;

use App\Models\usersModel;


class aipfTeamBonusLevelCheck extends Command
{
    protected $signature = 'teambonus:level:check';
    protected $description = 'Run TeamBonusService::checkLevel';

    public function handle(TeamBonusService $svc)
    {
        $logger = Log::channel('level_check'); // Use the custom channel

        $logger->info('--- TeamBonus Level Check Started ---');

        try {
            $svc->checkLevel();
            $logger->info('checkLevel() executed successfully.');

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
