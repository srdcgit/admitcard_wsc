<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlockController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\FarmingProfileController;
use App\Http\Controllers\Api\GramPanchyatController;
use App\Http\Controllers\Api\MonthlyFarmingReportController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\RespondentMasterController;
use App\Http\Controllers\Api\TrainingReportController;
use App\Http\Controllers\Api\VillageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login',[AuthController::class,'login'])->name('login');;
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'crp','middleware' => 'crp'], function () { 
        Route::resource('respondent-master', RespondentMasterController::class);
        Route::post('respondent-master/store', [RespondentMasterController::class,'store']);
        Route::resource('block', BlockController::class);
        Route::resource('village', VillageController::class);
        Route::resource('district', DistrictController::class);
        Route::resource('gram-panchyat', GramPanchyatController::class);
        Route::resource('farming-profile', FarmingProfileController::class);
        Route::post('farming-profile/store', [FarmingProfileController::class,'store']);
        Route::post('monthly_farming_report/store', [MonthlyFarmingReportController::class,'store']);
        Route::resource('monthly_farming_report',MonthlyFarmingReportController::class);
        Route::post('training_report/store', [TrainingReportController::class,'store']);
        Route::resource('training_report',TrainingReportController::class);
        Route::resource('project', ProjectController::class);
        // Route::post('logout',[AuthController::class,'logout'])->name('logout');;
    });
    Route::group(['prefix' => 'field_staff','middleware' => 'field_staff'], function () { 
        Route::get('respondent-master', [RespondentMasterController::class,'getFieldStaffIndex']);
        Route::get('farming-profile', [FarmingProfileController::class,'getFieldStaffIndex']);
        Route::get('monthly_farming_report', [MonthlyFarmingReportController::class,'getFieldStaffIndex']);
        Route::get('training_report', [TrainingReportController::class,'getFieldStaffIndex']);
        // Route::post('logout',[AuthController::class,'logout'])->name('logout');;
    });
});
