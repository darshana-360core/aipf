<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\ClubBonusService;

class aipfClubBonusRelease extends Command
{
    protected $signature = 'clubbonus:release';
    protected $description = 'Run Club Bonus';

    public function handle(ClubBonusService $svc): int
    {
        $svc->calculateClubBonus();

        $this->info('Club bonus released successfully.');
        return self::SUCCESS;
    }
}
