<?php

namespace App\Console\Commands;

use App\Services\StakePoolRewardService;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import the Log facade

class StakePoolRewardRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stakePoolReward:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'stake Pool Reward Release';

    /**
     * Execute the console command.
     */
    public function handle(Request $request)
    {

        $logger = Log::channel('stake_pool_reward_release'); // Use your custom channel

        $logger->info('--- stake Pool Reward Release Started ---');


        try 
        {
            $appHome = new StakePoolRewardService;

            $res = $appHome->StakePoolReward($request);

            $logger->info('Stake Pool Reward Release completed successfully.');
            
            $this->info('Stake Pool Reward Release completed successfully.');

        } 
        catch (\Throwable $e) 
        {
            $logger->error('Error during stake Pool Reward Release: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
        }

        $logger->info('--- stake Pool Reward Release Ended ---');


        // $appHome = new scriptController;

        // $res = $appHome->roiRelease($request);

        // $this->info('ROI Release excuted.');
        // $this->info($res);
    }
}
