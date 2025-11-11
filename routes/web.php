<?php

use App\Http\Controllers\AuthController;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
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


Route::get('/scan', function (Request $request) {
  // Store QR data in session temporarily
  session([
      'roll' => $request->get('roll'),
      'name' => $request->get('name'),
      'center' => $request->get('center'),
  ]);

  // Redirect to a clean page
  return redirect()->route('scan.display');
})->name('scan');

Route::get('/scan/display', function () {
  $roll = session('roll');
  $name = session('name');
  $center = session('center');

  if (!$roll || !$name || !$center) {
      return "<h2 style='text-align:center;color:red;'>⚠️ Invalid QR or Session Expired</h2>";
  }

  return view('scan_result', compact('roll', 'name', 'center'));
})->name('scan.display');


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

/****************** PUBLIC FORM ROUTES ****************/
Route::get('form/{slug}', function ($slug) {
    $form = \App\Models\Form::where('slug', $slug)->where('is_active', true)->firstOrFail();
    return view('forms.public', compact('form'));
})->name('form.public.show');

Route::post('form/{slug}', function (\Illuminate\Http\Request $request, $slug) {
    $form = \App\Models\Form::where('slug', $slug)->where('is_active', true)->firstOrFail();
    $payload = $request->except(['_token']);
    \App\Models\FormSubmission::create([
        'form_id' => $form->id,
        'submission_data' => $payload,
        'submitted_by' => $request->ip(),
    ]);
    if ($request->wantsJson()) {
        return response()->json(['success' => true]);
    }
    return back()->with('success', 'Submitted!');
})->name('form.public.submit');
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