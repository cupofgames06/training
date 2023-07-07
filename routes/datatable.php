<?php

use App\Http\Controllers\Dashboard\Company\CompanyLearnerController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\Of\OfCourseController;
use App\Http\Controllers\DataTableController;
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
//Route::prefix('{locale}')->middleware('set_locale')->group(function () {

    Route::prefix('datatable')->name('datatable.')->group(function () {
        Route::get('/company_learners_active', [CompanyLearnerController::class, 'getActiveLearners'])->name('company.learners.active');
        Route::get('/company_learners_left', [CompanyLearnerController::class, 'getLearnersLeft'])->name('company.learners.left');
        Route::get('/of_courses', [OfCourseController::class, 'getList'])->name('of.courses.list');
        Route::get('/company_best_courses', [CompanyController::class, 'getBestCourses'])->name('company.best.courses');
        Route::get('/courses', [DataTableController::class, 'getCourses'])->name('courses');
        Route::get('/of/{of}/monitoring/customer/{company}/learners/active', [DataTableController::class, 'getOfMonitoringCustomerLearnersActive'])->name('of.monitoring.customer.learners.active');
        Route::get('/of/{of}/monitoring/customer/{company}/learners/left', [DataTableController::class, 'getOfMonitoringCustomerLearnersLeft'])->name('of.monitoring.customer.learners.left');
    });
//});
