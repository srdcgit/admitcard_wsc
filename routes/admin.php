<?php

/****************** ADMIN MIDDLEWARE PAGES ROUTES START****************/

use App\Http\Controllers\Admin\CenterController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\ExamCoordinatorController;
use App\Http\Controllers\Admin\FormBuilderController;
use App\Http\Controllers\Admin\QueryController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:user'], function () {
    Route::group(['middleware' => 'admin'], function () {
        /*******************DASHBOARD ROUTE START*************/
        Route::view('dashboard', 'admin.dashboard.index')->name('dashboard.index');
        /*******************DASHBOARD ROUTE END*************/
        /*******************USER ROUTE START*************/
        Route::resource('user', UserController::class);
        /*******************USER ROUTE END*************/
        /*******************CENTER ROUTE START*************/
        Route::resource('center', CenterController::class);
        /*******************CENTER ROUTE END*************/
        /*******************STUDENT ROUTE START*************/
        Route::get('student/import', [StudentController::class, 'importForm'])->name('student.import');
        Route::post('student/import', [StudentController::class, 'import'])->name('student.import.store');
        Route::get('student/export-template', [StudentController::class, 'exportTemplate'])->name('student.export.template');
        Route::get('student/export-demo', [StudentController::class, 'exportDemo'])->name('student.export.demo');
        Route::resource('student', StudentController::class);
        /*******************STUDENT ROUTE END*************/
        /*******************DOWNLOAD ROUTE START*************/
        Route::resource('download', DownloadController::class);
        /*******************DOWNLOAD ROUTE END*************/
        /*******************QUERY ROUTE START*************/
        Route::get('query/solved/{id}', [QueryController::class, 'solved'])->name('query.solved');
        Route::resource('query', QueryController::class);
        /*******************QUERY ROUTE END*************/









        /*******************FORM BUILDER (Custom)*************/
        Route::get('/forms', [\App\Http\Controllers\Admin\FormController::class, 'list'])->name('forms.index');
        Route::get('/form-builder', [\App\Http\Controllers\Admin\FormController::class, 'index'])->name('form.builder');
        Route::post('/form-builder/save', [\App\Http\Controllers\Admin\FormController::class, 'store'])->name('form.save');
        Route::get('/form/{id}', [\App\Http\Controllers\Admin\FormController::class, 'show'])->name('form.show');
        Route::post('/form/{id}/submit', [\App\Http\Controllers\Admin\FormController::class, 'submit'])->name('form.submit');
        Route::get('/form/{id}/submissions', [\App\Http\Controllers\Admin\FormController::class, 'submissions'])->name('form.submissions');
        Route::get('/form/{id}/submit', function ($id) {
            return redirect()->route('admin.form.show', $id);
        });
        Route::post('/form/{id}/toggle-status', [\App\Http\Controllers\Admin\FormController::class, 'toggleStatus'])->name('form.toggle');
        Route::delete('/form/{id}', [\App\Http\Controllers\Admin\FormController::class, 'destroy'])->name('form.destroy');
        Route::get('/form/{id}/edit', [\App\Http\Controllers\Admin\FormController::class, 'edit'])->name('form.edit');
        Route::put('/form/{id}', [\App\Http\Controllers\Admin\FormController::class, 'update'])->name('form.update');









        /*******************EXAM COORDINATOR ROUTE START*************/

        Route::resource('examcoordinator', ExamCoordinatorController::class);
        /*******************EXAM COORDINATOR ROUTE END*************/
    });
});
/****************** ADMIN MIDDLEWARE PAGES ROUTES END****************/
