<?php

namespace App\Console\Commands;

use App\Http\Controllers\scriptController;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class activeTeam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'active:team';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Active Team';

    /**
     * Execute the console command.
     */
    public function handle(Request $request)
    {
        $appHome = new scriptController;

        $appHome->activeTeamCalculate($request);
    }
}