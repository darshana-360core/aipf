<?php

namespace App\Console\Commands;

use App\Http\Controllers\scriptController;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import the Log facade

class roiRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roi:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Roi & Level Income Release';

    /**
     * Execute the console command.
     */
    public function handle(Request $request)
    {

        $logger = Log::channel('roi_release'); // Use your custom channel

        $logger->info('--- Roi Release Started ---');


        try 
        {
            $appHome = new scriptController;

            $res = $appHome->roiRelease($request);

            $logger->info('Roi Release completed successfully.');
            
            $this->info('Roi Release completed successfully.');

        } 
        catch (\Throwable $e) 
        {
            $logger->error('Error during Roi Release: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
        }

        $logger->info('--- Roi Release Ended ---');


        // $appHome = new scriptController;

        // $res = $appHome->roiRelease($request);

        // $this->info('ROI Release excuted.');
        // $this->info($res);
    }
}
