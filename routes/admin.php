<?php 
/****************** ADMIN MIDDLEWARE PAGES ROUTES START****************/

use App\Http\Controllers\Admin\CenterController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\QueryController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as'=>'admin.','middleware' => 'auth:user'], function () {
    Route::group(['middleware' => 'admin'], function () {  
        /*******************DASHBOARD ROUTE START*************/       
        Route::view('dashboard','admin.dashboard.index')->name('dashboard.index');
        /*******************DASHBOARD ROUTE END*************/       
        /*******************USER ROUTE START*************/       
        Route::resource('user',UserController::class);
        /*******************USER ROUTE END*************/    
        /*******************CENTER ROUTE START*************/       
        Route::resource('center',CenterController::class);
        /*******************CENTER ROUTE END*************/   
        /*******************STUDENT ROUTE START*************/       
        Route::get('student/import',[StudentController::class,'importForm'])->name('student.import');
        Route::post('student/import',[StudentController::class,'import'])->name('student.import.store');
        Route::get('student/export-demo',[StudentController::class,'exportDemo'])->name('student.export.demo');
        Route::resource('student',StudentController::class);
        /*******************STUDENT ROUTE END*************/   
        /*******************DOWNLOAD ROUTE START*************/       
        Route::resource('download',DownloadController::class);
        /*******************DOWNLOAD ROUTE END*************/   
        /*******************QUERY ROUTE START*************/       
        Route::get('query/solved/{id}',[QueryController::class,'solved'])->name('query.solved');
        Route::resource('query',QueryController::class);
        /*******************QUERY ROUTE END*************/          
    });
});
/****************** ADMIN MIDDLEWARE PAGES ROUTES END****************/
?>