<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\OfferingController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\ProgramController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('academic', AcademicController::class);

Route::resource('course', CourseController::class);
Route::get('course/add_cotaught/{course_id}', [CourseController::class, 'add_cotaught']);
Route::post('course/cotaught/{course_id}', [CourseController::class, 'store_cotaught']);

Route::resource('offering', OfferingController::class);
Route::get('offering/{course_id}/create', [OfferingController::class, 'create']);
Route::post('offering/{course_id}', [OfferingController::class, 'store']);
Route::post('offering_copy', [OfferingController::class, 'copy']);


Route::post('dash', [DashController::class, 'courses']);
Route::post('dash/academics', [DashController::class, 'academics']);

Route::resource('program', ProgramController::class);


/**
 * Home page
 */
Route::get('/', function(){
    return view('index');
});
