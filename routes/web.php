<?php

use App\Http\Controllers\incomeOverviewController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\packagesController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\supportTicketController;
use App\Http\Controllers\teamController;
use App\Http\Controllers\withdrawController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\loginController as BackendLoginController;
use App\Http\Controllers\admin\withdrawController as BackendwithdrawController;
use App\Http\Controllers\admin\packageController as BackendpackageController;
use App\Http\Controllers\admin\usersController as BackendusersController;
use App\Http\Controllers\admin\levelRoiController as BackendlevelRoiController;
use App\Http\Controllers\admin\settingController as BackendsettingController;
use App\Http\Controllers\admin\orbitxPoolsController as BackendorbitxPoolsController;
use App\Http\Controllers\admin\rankBonusController as BackendrankBonusController;
use App\Http\Controllers\admin\roiDistributionController as BackendroiDistributionController;

use App\Http\Controllers\scriptController as scriptController;

use App\Http\Controllers\TestController;

// Route::any('/', [loginController::class, 'dashboard'])->middleware('session');

// // Login Page Route
// Route::get('/login', function () {
//     return view('pages.login');
// })->name('flogin');

// Route::any('/connect-wallet', [registerController::class, 'index'])->name('fregister');

// Route::post('/connect-wallet-process', [registerController::class, 'store'])->name('fregisterProcess');

// Route::post('/user-validate', [loginController::class, 'userValidate'])->name('fuserValidate');

// Route::post('/login-process', [loginController::class, 'login'])->name('floginProcess');

// Route::any('/dashboard', [loginController::class, 'dashboard'])->name('fdashboard')->middleware('session');

// Route::any('/logout', [loginController::class, 'logout'])->name('flogout');

// Route::any('/profile', [profileController::class, 'index'])->name('fprofile')->middleware('session');

// Route::any('/profile-update', [profileController::class, 'profile_update'])->name('fprofileUpdate')->middleware('session');

// Route::any('/password-update', [profileController::class, 'password_update'])->name('fpasswordUpdate')->middleware('session');

// Route::any('/packages', [packagesController::class, 'index'])->name('packages')->middleware('session');

// Route::any('/stake', [packagesController::class, 'stake'])->name('stake')->middleware('session');

// Route::any('/lpbonds', [packagesController::class, 'lpbonds'])->name('lpbonds')->middleware('session');

// Route::any('/stablebonds', [packagesController::class, 'stablebonds'])->name('stablebonds')->middleware('session');

// Route::any('/package-deposit', [packagesController::class, 'packageDeposit'])->name('packageDeposit')->middleware('session');

// Route::any('/process-package', [packagesController::class, 'processpackage'])->name('process.package')->middleware('session');

// Route::any('/topup-9pay', [packagesController::class, 'topup9pay'])->name('topup9pay')->middleware('session');

// Route::any('/topup-9pay-process-activation', [packagesController::class, 'topup9PayActivation'])->name('ftopup9PayActivation')->middleware('session');

// Route::any('/api-handle-package-transaction-9pay', [packagesController::class, 'apiHandlePackageTransaction9Pay'])->name('fapiHandlePackageTransaction9Pay')->middleware('session');

// Route::any('/api-handle-package-transaction', [packagesController::class, 'handlePackageTransaction'])->name('fhandlePackageTransaction')->middleware('session');

// Route::any('/check-package-transaction', [packagesController::class, 'checkPackageTransaction'])->name('check_package_transaction')->middleware('session');

// Route::any('/ajax-activate-package', [packagesController::class, 'ajaxActivatePackage'])->name('fajaxActivatePackage')->middleware('session');

// Route::post('/ajax-store-package', [packagesController::class, 'ajaxStorePackage'])->name('fajaxStorePackage')->middleware('session');

// Route::any('/cancel-pay-transaction', [packagesController::class, 'cancelPayTransaction'])->name('fcancelPayTransaction')->middleware('session');

// Route::any('/my-directs', [teamController::class, 'my_directs'])->name('fmy_directs')->middleware('session');

// Route::any('/my-team', [teamController::class, 'my_team'])->name('fmy_team')->middleware('session');

// Route::any('/genealogy', [teamController::class, 'genealogy_level_team'])->name('fgenealogy')->middleware('session');

// Route::any('/support-tickets', [supportTicketController::class, 'index'])->name('supportTicket')->middleware('session');

// Route::any('/process-support-tickets', [supportTicketController::class, 'support_ticket_process'])->name('supportTicketProcess')->middleware('session');
// Route::any('/user-details-store', [loginController::class, 'user_details_store'])->name('user_details_store')->middleware('session');
// Route::any('/user-rank-details-store', [loginController::class, 'user_rank_details_store'])->name('user_rank_details_store')->middleware('session');


// Route::get('/404', function () {
//     return view('pages.404');
// });

// // Route::get('/calculator', function () {
// //     return view('pages.calculator');
// // })->name('calculator');

// Route::get('/500', function () {
//     return view('pages.500');
// });
// // Activate Package (FUND) Page Route
// Route::get('/package-activation-pin', function () {
//     return view('pages.packages');
// });

// // Activate Package (Multichain USDT) Page Route
// Route::get('/package-topup-9pay', function () {
//     return view('pages.package_topup_9pay');
// });

// // Income Overview Page Route
// Route::any('/income-overview', [incomeOverviewController::class, 'index'])->name('fincomeOverview')->middleware('session');
// Route::any('/level-income-overview', [incomeOverviewController::class, 'levelIndex'])->name('flevelIncomeOverview')->middleware('session');

// Route::any('/withdraws', [withdrawController::class, 'index'])->name('fwithdraw')->middleware('session');

// Route::any('/withdraw-process', [withdrawController::class, 'withdrawProcess'])->name('fwithdrawProcess')->middleware('session');

// Route::any('/pool-rewards', [withdrawController::class, 'poolRewards'])->name('pool-rewards')->middleware('session');

// Route::any('/club-bonus', [withdrawController::class, 'clubBonus'])->name('club-bonus')->middleware('session');

// Route::any('/referral-code-details', [loginController::class, 'referralCodeDetails'])->name('freferralCodeDetails')->middleware('session');


// // BACKEND ROUTES

Route::get('1c4b4f09/', function (Request $request) {
    $user_id = $request->session()->get('admin_user_id');
    if (!empty($user_id)) {
        return redirect()->route('dashboard');
    } else {
        return view('login');
    }
})->name('index');

Route::post('1c4b4f09/login', [BackendLoginController::class, 'index'])->name('login');

// Route::any('1c4b4f09/login-otp', [BackendLoginController::class, 'loginviewotp'])->name('aloginviewotp');
// Route::post('1c4b4f09/login-otp-process', [BackendLoginController::class, 'otpProcess'])->name('aotpProcess');

Route::any('1c4b4f09/logout', [BackendLoginController::class, 'logout'])->name('logout');

Route::any('1c4b4f09/dashboard', [BackendLoginController::class, 'dashboard'])->name('dashboard')->middleware('adminsession');
Route::any('1c4b4f09/user-genealogy', [BackendusersController::class, 'user_genealogy'])->name('user_genealogy');
// Route::any('1c4b4f09/activated-admin-users', [BackendLoginController::class, 'activated_admin_users'])->name('activated_admin_users')->middleware('adminsession');

// Route::any('1c4b4f09/with-drawprocess', [BackendwithdrawController::class, 'withdrawProcess'])->name('withdrawProcess')->middleware('adminsession');
// Route::any('1c4b4f09/withdraw-save', [BackendwithdrawController::class, 'withdrawSave'])->name('withdrawSave')->middleware('adminsession');
Route::any('1c4b4f09/search-member', [BackendpackageController::class, 'searchMember'])->name('searchMember')->middleware('adminsession');
// Route::any('1c4b4f09/processpackage-member', [BackendpackageController::class, 'processpackage'])->name('processpackagemember')->middleware('adminsession');
// Route::any('1c4b4f09/update-member', [BackendusersController::class, 'updateUserDetails'])->name('updateUserDetails')->middleware('adminsession');
// Route::any('1c4b4f09/process-award-income', [BackendusersController::class, 'awardIncomeProcess'])->name('awardIncomeProcess')->middleware('adminsession');
// Route::any('1c4b4f09/member-support-tickets', [BackendusersController::class, 'memberSupportTickets'])->name('memberSupportTickets')->middleware('adminsession');
// Route::any('1c4b4f09/reply-support-tickets', [BackendusersController::class, 'replySupportTickets'])->name('replySupportTickets')->middleware('adminsession');
// Route::any('1c4b4f09/members-report', [BackendusersController::class, 'membersReport'])->name('membersReport')->middleware('adminsession');
Route::any('1c4b4f09/investment-process-report', [BackendusersController::class, 'investmentReportt'])->name('investmentReport')->middleware('adminsession');
Route::any('1c4b4f09/withdraw-process-report', [BackendusersController::class, 'withdrawReport'])->name('withdrawReport')->middleware('adminsession');
Route::any('1c4b4f09/roi-release-report', [BackendusersController::class, 'roiReleaseReport'])->name('roiReleaseReport')->middleware('adminsession');
Route::any('1c4b4f09/turbine-process-report', [BackendusersController::class, 'turbineReport'])->name('turbineReport')->middleware('adminsession');
Route::any('1c4b4f09/release-process-report', [BackendusersController::class, 'releaseReport'])->name('releaseReport')->middleware('adminsession');
Route::any('1c4b4f09/user-rank-report-process', [BackendusersController::class, 'userRankReport'])->name('userRankReport')->middleware('adminsession');
// Route::any('1c4b4f09/income-geneated-report-process', [loginController::class, 'incomeOverviewFilter'])->name('incomeOverviewFilter')->middleware('adminsession');
// Route::any('1c4b4f09/income-geneated-report-process-excel', [loginController::class, 'incomeOverviewFilterExcel'])->name('incomeOverviewFilterExcel')->middleware('adminsession');
// Route::any('1c4b4f09/user-details', [BackendusersController::class, 'userDetails'])->name('userDetails')->middleware('adminsession');
// Route::any('1c4b4f09/user-export-report', [BackendusersController::class, 'userExportReport'])->name('userExportReport')->middleware('adminsession');
// Route::any('1c4b4f09/process-rp3-transaction', [BackendpackageController::class, 'process_rp3_transaction'])->name('process_rp3_transaction')->middleware('adminsession');
// Route::any('1c4b4f09/withdraw_stop', [BackendusersController::class, 'withdraw_stop'])->name('withdraw_stop')->middleware('adminsession');
// Route::any('1c4b4f09/update_roi_stop_date', [BackendusersController::class, 'update_roi_stop_date'])->name('update_roi_stop_date')->middleware('adminsession');
// Route::any('1c4b4f09/update_level_stop_date', [BackendusersController::class, 'update_level_stop_date'])->name('update_level_stop_date')->middleware('adminsession');
// Route::any('1c4b4f09/website-popup', [BackendusersController::class, 'website_popup'])->name('website_popup')->middleware('adminsession');
// Route::any('1c4b4f09/add-website-popup', [BackendusersController::class, 'add_website_popup'])->name('add_website_popup')->middleware('adminsession');
// Route::any('1c4b4f09/process_business', [BackendusersController::class, 'process_business'])->name('process_business')->middleware('adminsession');
// Route::any('1c4b4f09/process-team-strong-business', [BackendusersController::class, 'processTeamStrongBusiness'])->name('process_team_strong_business')->middleware('adminsession');
// Route::any('1c4b4f09/team-strong-business', [BackendusersController::class, 'teamStrongBusiness'])->name('team_strong_business')->middleware('adminsession');
Route::any('1c4b4f09/level-income-report', [BackendusersController::class, 'level_income_report'])->name('level_income_report')->middleware('adminsession');
// Route::any('1c4b4f09/power-business-report', [BackendusersController::class, 'power_business_report'])->name('power_business_report')->middleware('adminsession');
// Route::any('1c4b4f09/remove-power-business', [BackendusersController::class, 'remove_power_business'])->name('remove_power_business')->middleware('adminsession');
Route::any('1c4b4f09/orbitx-pool-repor-process', [BackendusersController::class, 'orbitx_pool_report'])->name('orbitx_pool_report')->middleware('adminsession');
// Route::any('1c4b4f09/orbitx-api-pool-report-process', [BackendusersController::class, 'orbitx_api_pool_report'])->name('orbitx_api_pool_report')->middleware('adminsession');
// Route::any('1c4b4f09/stablebonds_userdetail-report-process', [BackendusersController::class, 'stablebonnds_userdetail_report_process'])->name('stablebonnds_userdetail_report_process')->middleware('adminsession');
// Route::any('1c4b4f09/stablebonds_userdetail-report', [BackendusersController::class, 'stablebonnds_userdetail_report_process'])->name('stablebonds_userdetail_report')->middleware('adminsession');
// Route::any('1c4b4f09/event-report-process', [BackendusersController::class, 'userdetail_rank_report_process'])->name('userdetail_rank_report_process')->middleware('adminsession');
// Route::any('1c4b4f09/event-report', [BackendusersController::class, 'userdetail_rank_report_process'])->name('userdetail_rank_report')->middleware('adminsession');

// Route::get('1c4b4f09/withdraw-report', function (Request $request) {
//     return view('withdraw_report');
// })->name('withdraw_report');
Route::get('1c4b4f09/orbitx-pool-report', function (Request $request) {
    return view('orbitx_pool');
})->name('orbitx_pool');
Route::get('1c4b4f09/user-rank-report', function (Request $request) {
    return view('user_rank_report');
})->name('user_rank_report');
// Route::get('1c4b4f09/orbitx-api-pool-report', function (Request $request) {
//     return view('orbitx_api_pool');
// })->name('orbitx_api_pool');

// Route::get('1c4b4f09/investment-report', function (Request $request) {
//     return view('investment_report');
// })->name('investment_report');

// Route::get('1c4b4f09/report', function (Request $request) {
//     return view('report');
// })->name('report');

// Route::get('1c4b4f09/report-users', function (Request $request) {
//     return view('user_export_report');
// })->name('report_users');

// Route::get('1c4b4f09/income-geneated-report', function (Request $request) {
//     return view('income_generated_report');
// })->name('incomeGReport');

// Route::any('1c4b4f09/income-geneated-report-process', [BackendLoginController::class, 'incomeOverviewFilter'])->name('incomeOverviewFilter')->middleware('adminsession');

Route::group(['prefix' => '1c4b4f09', 'middleware' => ['adminsession']], function () {
//     Route::resource('level-roi', BackendlevelRoiController::class);
//     Route::resource('package', BackendpackageController::class);
//     Route::resource('setting', BackendsettingController::class);
    Route::resource('users', BackendusersController::class);
//     Route::resource('withdraw', BackendwithdrawController::class);
//     Route::resource('rank-bonus', BackendrankBonusController::class);
//     Route::resource('roi-distribution-import', BackendroiDistributionController::class);
//     Route::resource('orbitx-pool', BackendorbitxPoolsController::class);
});
// Route::any('/roi-release', [scriptController::class, 'roiReleaseShikhar'])->name('roirelease')->middleware('session');
Route::GET('/star-bonus', [scriptController::class, 'starBonus'])->name("starBonus");


// Route::any('/shikhar/{userid}', [TestController::class, 'testMethod'])->name('testmethod');

Route::any('/test-bonus', [TestController::class, 'testTest'])->name('testbonus');
// Route::get('/test-reward/{userId}', [TestController::class, 'testUserReward']);

// Route::get('/uplines/{userId}/{maxLevels?}', [teamController::class, 'getUplines'])->name('getuplines');

// Route::get('/checkuplinebonus/{userId}', [teamController::class, 'checkUplineBonus'])->name('checkUplineBonus');

// Route::get('/checkrankrewardbonus/{userId}', [teamController::class, 'checkRankRewardBonus'])->name('checkRankRewardBonus');

// Route::get('/checkpoolbonus/{userId}/{withdrawAmount}', [teamController::class, 'checkPoolBonus'])->name('checkPoolBonus');

// Route::get('/checkclubbonus', [teamController::class, 'checkClubBonus'])->name('checkClubBonus');

// Route::get('/authrsvp', [TestController::class, 'verifyRSVPString'])->name('authrsvp');



Route::any('/test', [loginController::class, 'testTest'])->name('test');
Route::GET('/stake-pool-reward', [scriptController::class, 'StakePoolReward'])->name("StakePoolReward");
