<?php

use App\Http\Controllers\AuthController;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/******************LOGIN PAGE ROUTES START****************/
// Route::view('/home','auth.login');
Route::get('/',[AuthController::class,'home'])->name('home');
Route::view('login','auth.login');
Route::view('query','front.query.index');
Route::post('query/store',[AuthController::class,'queryStore'])->name('query.store');
Route::post('login',[AuthController::class,'login'])->name('login');
/******************LOGIN PAGE ROUTES END****************/
/*******************LOGOUT ROUTE START*************/       
Route::get('logout',[AuthController::class,'logout'])->name('logout');
/*******************LOGOUT ROUTE END*************/     


/*******************ADMIN ROUTE START*************/       
include __DIR__ . '/admin.php';
/*******************ADMIN ROUTE END*************/     
/******************FUNCTIONALITY ROUTES****************/
Route::get('cd', function() {
    Artisan::call('config:cache');
    Artisan::call('migrate:refresh');
    Artisan::call('db:seed', [ '--class' => DatabaseSeeder::class]);
    Artisan::call('view:clear');
    return 'DONE';
  });
  Route::get('migrate', function() {
    Artisan::call('config:cache');
    Artisan::call('migrate');
    Artisan::call('view:clear');
    return 'DONE';
  });
  Route::get('cache_clear', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return 'DONE';
  });