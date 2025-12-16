<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\packagesController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\withdrawController;
use App\Http\Controllers\teamController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\incomeOverviewController;
use App\Http\Controllers\turbineController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\scriptController;
use App\Services\TeamBonusService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('custom.api.throttle')->group(function () {
    
    Route::any('/test', [loginController::class, 'testTest']); //No

    Route::any('/active-trades', [loginController::class, 'activeTrades']); //No

    Route::any('/toast-details', [loginController::class, 'toastDetails']); //No

    Route::any('/dashboard', [loginController::class, 'dashboard']);

    Route::post('/login-process', [loginController::class, 'login']); //No

    Route::post('/connect-wallet-process', [registerController::class, 'store']); //No

    Route::any('/my-directs', [teamController::class, 'my_directs']);

    Route::any('/my-team', [teamController::class, 'my_team']);

    Route::any('/genealogy', [teamController::class, 'genealogy_level_team']); //No

    // Contract Event : unstake
    // Contract Event : claim roi
    Route::any('/api-handle-withdraw-transaction', [withdrawController::class, 'handleWithdrawTransaction']); //No

    Route::any('/pool-rewards', [withdrawController::class, 'poolRewards']);

    Route::any('/withdraws', [withdrawController::class, 'index']);

    Route::any('/income-overview', [incomeOverviewController::class, 'index']);

    Route::any('/api-handle-package-transaction-9pay', [packagesController::class, 'apiHandlePackageTransaction9Pay']); //No

    Route::any('/api-handle-package-transaction', [packagesController::class, 'handlePackageTransaction']); //No

    // Route::any('/turbine-generated', [packagesController::class, 'handleTurbine']);

    // Route::any('/turbine-claim-roi-generated', [packagesController::class, 'handleTurbineClaimRoi']);

    // Route::any('/turbine-unstake-generated', [packagesController::class, 'handleTurbineUnstake']);

    // Route::any('/turbine-removed', [packagesController::class, 'handleTurbineRelease']);

    Route::any('/stablebonds', [packagesController::class, 'stablebonds']);

    Route::any('/lpbonds', [packagesController::class, 'lpbonds']);

    Route::any('/stake', [packagesController::class, 'stake']);

    // Route::any('/turbine', [turbineController::class, 'index']);

    // NEW APIS ADDED earlier stake-release-history
    // Route::any('/revenue-resource-details', [packagesController::class, 'revenueResourceDetails']);
    
    Route::any('/earning-receive-history', [packagesController::class, 'earningLogsHistory']);

    // Route::any('/stakedata', [packagesController::class, 'stakeData']);

    Route::any('/stake-details', [packagesController::class, 'stakingReleaseHistoryStakeid']);

    Route::post('/user-validate', [loginController::class, 'userValidate'])->name('fuserValidate');

    // Contract Event : release
    Route::any('/turbine-vesting-history', [packagesController::class, 'turbineVestingHistory']);
    
    // Route::any('/turbine-vesting-list', [packagesController::class, 'turbineVestingList']);

    
    //stake-roi-unstake
    Route::any('/stakeing-rebase-history', [packagesController::class, 'stakingRebaseHistory']);

    //claim-release
    Route::any('/revenue-source-details', [packagesController::class, 'revenueSourceDetails']);    

    //release history or /turbine-vesting-list
    Route::any('/release-history', [packagesController::class, 'releaseHistory']);

    Route::any('/user-balances', [packagesController::class, 'userBalance']);

    Route::any('/turbine-release-history', [packagesController::class, 'turbineReleaseHistory']);



    Route::any('sync-income', [incomeOverviewController::class, 'syncEarningLogs']);

    Route::any('sync-income-update', [incomeOverviewController::class, 'syncEarningLogsUpdate']);

    Route::any('sync-level-income', [incomeOverviewController::class, 'syncLevelEarningLogs']);

    Route::any('sync-level-income-update', [incomeOverviewController::class, 'syncLevelEarningLogsUpdate']);


    // Contract Event : turbine withdraw
    Route::any('/process-turbine-release', [packagesController::class, 'processTurbineRelease']);


    // To test only remove afterwards
    Route::get('/test-checklevel', [TeamBonusService::class, 'checkLevel']);
    // Route::get('/test-bonus', [loginController::class, 'testBonusDistribution']);
    // Route::get('/test-rankreward', [loginController::class, 'testRankReward']);
    // Route::get('/test-roirelease', [loginController::class, 'testRoiRelease']);
    // Route::get('/test-pool', [loginController::class, 'directPoolReward']);
    // Route::post('/legs', [loginController::class, 'getTeamBusiness']);

    Route::any('/testtest', [TestController::class, 'testTest']);
    Route::any('/stake-pool-reward', [scriptController::class, 'StakePoolReward']);
    Route::any('/stake-pool-reward-save', [scriptController::class, 'StakePoolRewardSave']);
    

// });
