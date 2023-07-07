<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginWithGoogleController;
use App\Http\Controllers\Dashboard\Company\CompanyLearnerController;
use App\Http\Controllers\Dashboard\Company\CompanyMonitoringLearnerController;
use App\Http\Controllers\Dashboard\Company\CompanyProfileController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\Company\CompanyUserController;
use App\Http\Controllers\Dashboard\Of\OfAccessRuleController;
use App\Http\Controllers\Dashboard\Of\OfClassroomController;
use App\Http\Controllers\Dashboard\Of\OfIntraTrainingController;
use App\Http\Controllers\Dashboard\Of\OfMonitoringController;
use App\Http\Controllers\Dashboard\Of\OfPackController;
use App\Http\Controllers\Dashboard\Of\OfProfileController;
use App\Http\Controllers\Dashboard\Of\OfPromotionController;
use App\Http\Controllers\Dashboard\Of\OfQuizController;
use App\Http\Controllers\Dashboard\Of\OfSessionController;
use App\Http\Controllers\Dashboard\Of\OfSupportController;
use App\Http\Controllers\Dashboard\Of\OfTrainerController;
use App\Http\Controllers\Dashboard\Of\OfUserController;
use App\Http\Controllers\Dashboard\OfHomeController;
use App\Http\Controllers\Dashboard\Trainer\TrainerProfileController;
use App\Http\Controllers\Dashboard\Trainer\TrainerSessionController;
use App\Http\Controllers\Dashboard\TrainerController;
use App\Http\Controllers\Front\FrontOfferController;
use App\Http\Controllers\Dashboard\LearnerController;
use App\Http\Controllers\Dashboard\Of\OfCourseController;
use App\Http\Controllers\Dashboard\OfController;
use App\Http\Controllers\Dashboard\SuperAdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartialController;
use App\Http\Controllers\Quiz\QuizController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
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

Route::prefix('test')->group(function () {
    Route::get('mail', [TestController::class, 'mail'])->name('mail');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('authorized/google', [LoginWithGoogleController::class, 'redirectToGoogle'])->name('google');
    Route::get('authorized/google/callback', [LoginWithGoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::prefix('{locale}')->middleware('set_locale')->group(function () {

    Route::middleware('auth')->group(function () {
        Route::get('switch-account/{role}/{id}', [LoginController::class, 'switchAccount'])->name('switch-account');
    });

    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Auth::routes();

    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('show/{page_id}', [QuizController::class, 'show'])->name('show');
    });

    Route::group(['prefix' => 'front'], function () {
        Route::prefix('offers')->name('front.offers.')->group(function () {
            Route::get('index', [FrontOfferController::class, 'index'])->name('index');
            Route::get('course/{course_id}/{session_id?}', [FrontOfferController::class, 'course'])->name('course');
            Route::get('session/{session_id}', [FrontOfferController::class, 'session'])->name('session');
            Route::get('pack/{pack_id}', [FrontOfferController::class, 'pack'])->name('pack');
            Route::get('blended/{blended_id}', [FrontOfferController::class, 'blended'])->name('blended');
            Route::get('pack-content/{pack_id}', [FrontOfferController::class, 'pack_content'])->name('pack-content');
            Route::get('trainers/{session_id}', [FrontOfferController::class, 'trainers'])->name('trainers');
        });
    });

    Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {

        Route::get('preview-media/{media}', function () {
            //todo V2 ; ouvre modal, évntuellement  avec cropper, via swa alert ou bs
        })->name('preview-media');

        Route::prefix('super-admin')->middleware(['role:super-admin'])->name('super-admin.')->group(function () {
            //Route::get('/index', [SuperAdminController::class, 'index'])->name('index');
        });

        Route::prefix('trainer')->middleware(['role:trainer'])->name('trainer.')->group(function () {

            Route::get('/help', [TrainerController::class, 'help'])->name('help');
            Route::get('/index', [TrainerController::class, 'index'])->name('index');

            Route::controller(TrainerProfileController::class)->prefix('profile')->name('profile.')->group(function () {
                Route::patch('/upload_signature', 'upload_signature')->name('upload_signature');
                Route::get('/edit', 'edit')->name('edit');
                Route::patch('/update', 'update')->name('update');
            });

            Route::controller(TrainerSessionController::class)->prefix('sessions')->name('sessions.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('{session}/show', 'show')->name('show');
            });

        });

        Route::prefix('learner')->middleware(['role:learner'])->name('learner.')->group(function () {
            Route::get('/help', [LearnerController::class, 'help'])->name('help');
            Route::get('/index', [LearnerController::class, 'index'])->name('index');
        });

        Route::prefix('company')->middleware(['role:company'])->name('company.')->group(function () {

            Route::get('/index', [CompanyController::class, 'index'])->name('index');
            Route::get('/help', [CompanyController::class, 'help'])->name('help');
            Route::get('/indicators', [PartialController::class, 'indicators'])->name('indicators');
            Route::get('/overview', [PartialController::class, 'overview'])->name('overview');

            Route::controller(CompanyLearnerController::class)->prefix('learners')->name('learners.')->group(function () {

                Route::get('', 'index')->name('index');

                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/{learner}/edit/', 'edit')->name('edit');
                Route::patch('update/{learner}', 'update')->name('update');
                Route::delete('delete/{learner}', 'delete')->name('delete');
            });

            Route::controller(CompanyMonitoringLearnerController::class)->prefix('monitoring')->name('monitoring.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/{learner}/details', 'details')->name('details');
                Route::get('/ratings', [PartialController::class, 'ratings'])->name('ratings');
                Route::get('course/{course_id}/{session_id?}', 'course')->name('course');
                Route::get('session/{session_id}', 'session')->name('session');
                Route::get('pack/{pack_id}', 'pack')->name('pack');
                Route::get('blended/{blended_id}', 'blended')->name('blended');
            });

            Route::controller(CompanyUserController::class)->prefix('users')->name('users.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/{user}/edit/', 'edit')->name('edit');
                Route::patch('update/{user}', 'update')->name('update');
                Route::delete('delete/{user}', 'delete')->name('delete');
                Route::get('reinvite/{user}', 'reinvite')->name('reinvite');
            });

            Route::controller(CompanyProfileController::class)->prefix('profile')->name('profile.')->group(function () {
                Route::patch('/upload_tampon', 'upload_tampon')->name('upload_tampon');
                Route::patch('/upload_signature', 'upload_signature')->name('upload_signature');
                Route::get('/edit', 'edit')->name('edit');
                Route::patch('/update', 'update')->name('update');
            });

        });

        Route::prefix('of')->middleware(['role:of'])->name('of.')->group(function () {
            Route::get('/help', [OfController::class, 'help'])->name('help');
            Route::get('/index', [OfHomeController::class, 'index'])->name('index');


            Route::controller(OfQuizController::class)->prefix('quizzes')->name('quizzes.')->group(function () {

                Route::patch('toggle-version-status/{version}/{status}', 'toggle_version_status')->name('toggle-version-status');


                Route::patch('store_module/{page}', 'store_module')->name('store_module');
                Route::post('update_module', 'update_module')->name('update_module');
                Route::post('update_modules_position', 'update_modules_position')->name('update_modules_position');

                Route::post('store_image/{module}', 'store_image')->name('store_image');
                Route::delete('delete_image/{module}', 'delete_image')->name('delete_image');

                Route::delete('delete_module/{module}', 'delete_module')->name('delete_module');

                Route::patch('store_page/{version}', 'store_page')->name('store_page');
                Route::post('update_page/{page}', 'update_page')->name('update_page');
                Route::delete('delete_page/{page}', 'delete_page')->name('delete_page');

                Route::patch('store_version/{quiz}', 'store_version')->name('store_version');
                Route::patch('copy_version/{version}', 'copy_version')->name('copy_version');
                Route::post('update_version/{version}', 'update_version')->name('update_version');
                Route::delete('delete_version/{version}', 'delete_version')->name('delete_version');

                Route::patch('store_qcm_answer/{module}', 'store_qcm_answer')->name('store_qcm_answer');
                Route::delete('delete_qcm_answer/{module}/{position}', 'delete_qcm_answer')->name('delete_qcm_answer');

                Route::patch('store_accordion_item/{module}', 'store_accordion_item')->name('store_accordion_item');
                Route::delete('delete_accordion_item/{module}/{position}', 'delete_accordion_item')->name('delete_accordion_item');

                Route::patch('store_slider_item/{module}', 'store_slider_item')->name('store_slider_item');
                Route::delete('delete_slider_item/{module}/{position}', 'delete_slider_item')->name('delete_slider_item');


            });

            Route::controller(OfProfileController::class)->prefix('profile')->name('profile.')->group(function () {
                Route::get('edit', 'edit')->name('edit');
                Route::patch('update', 'update')->name('update');
                Route::patch('/upload_tampon', 'upload_tampon')->name('upload_tampon');
                Route::patch('/upload_signature', 'upload_signature')->name('upload_signature');
            });

            Route::controller(OfUserController::class)->prefix('users')->name('users.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/{user}/edit/', 'edit')->name('edit');
                Route::patch('update/{user}', 'update')->name('update');
                Route::delete('delete/{user}', 'delete')->name('delete');
                Route::get('reinvite/{user}', 'reinvite')->name('reinvite');
            });

            Route::controller(OfPromotionController::class)->prefix('promotions')->name('promotions.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('{promotion}/edit/', 'edit')->name('edit');
                Route::patch('update/{promotion}', 'update')->name('update');
                Route::delete('destroy/{promotion}', 'destroy')->name('destroy');
            });

            Route::controller(OfMonitoringController::class)->prefix('monitoring')->name('monitoring.')->group(function () {
                Route::get('sessions', 'sessions')->name('sessions');
                Route::get('sessions/{session}/details', 'session_details')->name('sessions.details');
                Route::get('elearnings', 'elearnings')->name('elearnings');
                Route::get('elearning/{enrollment}/details', 'elearning_details')->name('elearning.details');
                Route::get('customers', 'customers')->name('customers');
                Route::get('customer/{company}/details', 'customer_details')->name('customer.details');
                Route::get('customer/ratings', [PartialController::class, 'ratings'])->name('customer.ratings');
                Route::get('customer/indicators', [PartialController::class, 'indicators'])->name('customer.indicators');
                Route::get('customer/overview', [PartialController::class, 'overview'])->name('customer.overview');
                Route::get('customer/{company}/learner/{learner}/details', 'customer_learner_details')->name('customer.leaner.details');
                Route::get('course/{course_id}/{session_id?}', 'course')->name('course');
                Route::get('session/{session_id}', 'session')->name('session');
                Route::get('pack/{pack_id}', 'pack')->name('pack');
                Route::get('blended/{blended_id}', 'blended')->name('blended');
            });

            Route::controller(OfClassroomController::class)->prefix('classrooms')->name('classrooms.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('{classroom}/edit/', 'edit')->name('edit');
                Route::patch('update/{classroom}', 'update')->name('update');
                Route::delete('destroy/{classroom}', 'destroy')->name('destroy');
            });

            Route::controller(OfAccessRuleController::class)->prefix('access-rules')->name('access-rules.')->group(function () {
                Route::post('store/{item_type}/{item_id}', 'store')->name('store');
                Route::patch('update/{access_rule}', 'update')->name('update');
                Route::delete('delete/{access_rule}', 'delete')->name('delete');
            });

            Route::controller(OfIntraTrainingController::class)->prefix('intra-trainings')->name('intra-trainings.')->group(function () {
                Route::post('store/{item_type}/{item_id}', 'store')->name('store');
                Route::patch('update/{intra}', 'update')->name('update');
                Route::delete('delete/{intra}', 'delete')->name('delete');
            });

            Route::controller(OfSupportController::class)->prefix('supports')->name('supports.')->group(function () {
                Route::post('store/{item_type}/{item_id}', 'store')->name('store');
                Route::patch('update/{support}', 'update')->name('update');
                Route::delete('delete/{support}', 'delete')->name('delete');
                Route::any('upload_document/{item_id?}', 'upload_document')->name('upload_document');
            });

            Route::controller(OfTrainerController::class)->prefix('trainers')->name('trainers.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('{trainer}/edit/', 'edit')->name('edit');
                Route::patch('update/{trainer}', 'update')->name('update');
                Route::delete('destroy/{trainer}', 'destroy')->name('destroy');
                Route::any('/upload_signature', 'upload_signature')->name('upload_signature');
            });

            Route::controller(OfCourseController::class)->prefix('courses')->name('courses.')->group(function () {

                Route::patch('toggle-status/{course}/{status}', 'toggle_status')->name('toggle-status');

                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');

                Route::get('{course}/edit/', 'edit')->name('edit');
                Route::patch('update/{course}', 'update')->name('update');
                Route::delete('destroy/{course}', 'destroy')->name('destroy');

                Route::any('upload_image/{course?}', 'upload_image')->name('upload_image');

                Route::get('access_rules/{course}', 'access_rules')->name('access_rules');
                Route::get('intras/{item}', 'intras')->name('intras');
                Route::get('supports/{item}', 'supports')->name('supports');

                Route::get('pre_requisite_quiz/{course}/{version?}/{page?}', 'pre_requisite_quiz')->name('pre_requisite_quiz');
                Route::get('evaluation_quiz/{course}/{version?}/{page?}', 'evaluation_quiz')->name('evaluation_quiz');
                Route::get('elearning_selection/{course}', 'elearning_selection')->name('elearning_selection');
                Route::post('elearning_selected/{course}', 'elearning_selected')->name('elearning_selected');
                Route::get('elearning_quiz/{course}/{version?}/{page?}', 'elearning_quiz')->name('elearning_quiz');

            });

            $pack_types = [
                'packs', 'blendeds'
            ];

            foreach ($pack_types as $type) {
                Route::controller(OfPackController::class)->prefix($type)->name($type . '.')->group(function () {

                    Route::patch('toggle-status/{pack}/{status}', 'toggle_status')->name('toggle-status');

                    Route::get('', 'index')->name('index');
                    Route::get('create', 'create')->name('create');
                    Route::post('store', 'store')->name('store');

                    Route::get('{pack}/edit/', 'edit')->name('edit');
                    Route::patch('update/{pack}', 'update')->name('update');
                    Route::delete('destroy/{pack}', 'destroy')->name('destroy');

                    Route::any('upload_image/{pack?}', 'upload_image')->name('upload_image');

                    Route::get('packables/{pack}', 'packables')->name('packables');
                    Route::post('store_packable/{pack}', 'store_packable')->name('store_packable');
                    Route::delete('delete_packable/{item}', 'delete_packable')->name('delete_packable');
                    Route::post('update_position', 'update_position')->name('update_position');

                    Route::get('intras/{item}', 'intras')->name('intras');
                    Route::get('supports/{item}', 'supports')->name('supports');

                    Route::get('pre_requisite_quiz/{course}/{version?}/{page?}', 'pre_requisite_quiz')->name('pre_requisite_quiz');

                    Route::get('activate/{pack}', 'activate')->name('activate');
                });
            }


            Route::controller(OfSessionController::class)->prefix('sessions')->name('sessions.')->group(function () {

                Route::patch('toggle-status/{session}/{status}', 'toggle_status')->name('toggle-status');

                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('{session}/edit/', 'edit')->name('edit');
                Route::patch('update/{session}', 'update')->name('update');
                Route::delete('destroy/{session}', 'destroy')->name('destroy');

                Route::get('activate/{session}', 'activate')->name('activate');

                Route::get('trainers/{session}', 'trainers')->name('trainers');
                Route::patch('store_trainer/{session}', 'store_trainer')->name('store_trainer');
                Route::patch('update_trainer/{session}/{trainer}', 'update_trainer')->name('update_trainer');
                Route::patch('delete_trainer/{session}/{trainer}', 'delete_trainer')->name('delete_trainer');

                Route::get('intras/{item}', 'intras')->name('intras');
                Route::get('supports/{item}', 'supports')->name('supports');

                Route::get('days/{session}', 'days')->name('days');
                Route::patch('store_day/{session}', 'store_day')->name('store_day');
                Route::patch('update_day/{session}/{day}', 'update_day')->name('update_day');
                Route::patch('delete_day/{session}/{day}', 'delete_day')->name('delete_day');

                Route::post('get_course/{course_id?}', 'get_course')->name('get_course');

            });

        });
    });
});
