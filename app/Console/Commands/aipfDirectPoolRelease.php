<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import the Log facade
use App\Services\DirectPoolService;


class aipfDirectPoolRelease extends Command
{
    protected $signature = 'directpool:release';
    protected $description = 'Run TeamBonusService::distributeBonus';

    public function handle(DirectPoolService $svc): int
    {
        $logger = Log::channel('direct_pool'); // Use your custom channel

        $logger->info('--- Direct Pool Release Started ---');

        try 
        {
            $svc->directPoolReward();
            $logger->info('Direct Pool Reward completed successfully.');
            
            $this->info('Direct Pool Reward completed successfully.');

        } 
        catch (\Throwable $e) 
        {
            $logger->error('Error during Direct Pool Release: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
        }

        $logger->info('--- Direct Pool Release Ended ---');

        return self::SUCCESS;

        // $resp = $svc->directPoolReward();
        // echo $resp.PHP_EOL;
        // $this->info('Direct Pool Reward completed successfully.');
        // return self::SUCCESS;
    }
}
