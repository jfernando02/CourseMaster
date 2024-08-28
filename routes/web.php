<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\OfferingController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TrimesterController;

use Illuminate\Support\Facades\DB;

use Jumbojett\OpenIDConnectClient;



/*
|--------------------------------------------------------------------------

@@ -28,117 +14,18 @@ use Jumbojett\OpenIDConnectClient;
|
*/

Route::resource('academic', AcademicController::class);
Route::post('/academic/toggle-offerings', [AcademicController::class, 'toggleOfferings'])->name('academic.toggleOfferings');
Route::post('/academic/save', [AcademicController::class, 'saveAcademics'])->name('academic.save');
Route::get('/academic/editbulk/{id}', [AcademicController::class, 'edit_bulk'])->name('academic.editbulk');

Route::post('/academic/import', [AcademicController::class, 'import'])->name('academic.import');
Route::get('/academic/export/{id}', [AcademicController::class, 'export'])->name('academic.export');
Route::get('/academic/exportWorkload/{id}', [AcademicController::class, 'exportWorkload'])->name('academic.exportWorkload');

Route::resource('course', CourseController::class);
Route::get('course/add_cotaught/{course_id}', [CourseController::class, 'add_cotaught']);
Route::post('course/cotaught/{course_id}', [CourseController::class, 'store_cotaught']);
Route::post('/course/save', [CourseController::class, 'saveCourses'])->name('course.save');
Route::post('/course/import', [CourseController::class, 'import'])->name('course.import');
Route::get('/course/export/{id}', [CourseController::class, 'export'])->name('course.export');

// Need to review these routes, not all resource routes are used.
Route::resource('offering', OfferingController::class);
Route::get('offering/{course_id}/create', [OfferingController::class, 'create']);
Route::post('offering/{course_id}', [OfferingController::class, 'store']);
Route::post('offering_copy', [OfferingController::class, 'copy']);
Route::get('offering', [OfferingController::class, 'index']);
Route::get('offering/edit_bulk/1', [OfferingController::class, 'edit_bulk'])->name('offering.edit_bulks');

Route::post('offering/edit_bulk/1', [OfferingController::class, 'saveOfferings'])->name('offering.saveBulk');


Route::post('offering/import/{id}', [OfferingController::class, 'import'])->name('offering.import');
Route::get('/offering/export/{id}', [OfferingController::class, 'export'])->name('offering.export');


Route::post('dash', [DashController::class, 'courses']);
Route::post('dash/academics', [DashController::class, 'academics']);


Route::resource('program', ProgramController::class);

Route::resource('reports', ReportsController::class);////reports
Route::get('reports/reportbycampus/{id}', [ReportsController::class, 'reportbycampus']);
Route::post('reports/teachingstaffhistory', [ReportsController::class, 'teachingStaffHistory'])->name('reports.teachingStaffHistory');
// Route::get('reports/academics', [ReportController::class,'listAcademics'])->name('reports.academics');

//settings routes
Route::resource('settings', SettingsController::class);
Route::get('settings', [SettingsController::class, 'index']);


Route::post('search', [CourseController::class, 'search']);

//Trimesters
Route::resource('trimester', TrimesterController::class);
Route::get('trimester/', [TrimesterController::class, 'index'])->name('trimester.index');
// Route::get('trimester/create', [TrimesterController::class, 'create'])->name('trimester.create');
// Route::get('trimester/edit', [TrimesterController::class, 'edit'])->name('trimester.edit');
Route::get('/trimester/edit/{year}/{trimester}', [TrimesterController::class, 'edit'])->name('trimester.edit');

Route::post('trimester/delete', [TrimesterController::class, 'delete'])->name('trimester.delete');
Route::post('trimester/copy', [TrimesterController::class, 'copy'])->name('trimester.copy');
Route::post('trimester/save', [TrimesterController::class, 'save'])->name('trimester.save');
Route::post('/update-row', [TrimesterController::class, 'updateRow'])->name('trimester.update-row');
Route::post('/save-row', [TrimesterController::class, 'saveRow'])->name('save.row');
Route::post('/trimester/import', [TrimesterController::class, 'import'])->name('trimester.import');
Route::get('/trimester/export/{year}/{trimester}', [TrimesterController::class, 'export'])->name('trimester.export');



// Route::post('/class-schedule/{id}/delete', AcademicController::class, 'deleteClassSchedule')->name('class-schedule.delete');
Route::post('/academic/{id}/delete-class-schedule', [AcademicController::class, 'deleteClassSchedule'])->name('academic.delete-class-schedule');




Route::get('log', function () {
    $oidc = new OpenIDConnectClient('https://test-auth.griffith.edu.au',
        'oidc-coursemaster',
        'ryIAOL6oqowD28aCkQLgDbB1nUX7C3YK11AqJ0VPWcdupnIUJd4ccNkA3eqAyDNQ');
//     $oidc->setCertPath('/path/to/my.cert');
    $oidc->authenticate();
    dd();
});
/**
 * Home page
 */


Route::get('/', function() {
    if (Auth::check()) {
        $user = Auth::user();
        $name = $user->name;
        $academic_id = DB::table('academics')->where('email',$user->email)->first();
        if($academic_id) {
            $academic_id = $academic_id->id;
        } else {
            $academic_id = DB::table('academics')->inRandomOrder()->first()->id;
        }
    }

    // get setting through model
    $setting = \App\Models\Setting::latest()->first();
    $department = $setting ? $setting->department : null;
    $threshold_trimester = $setting ? $setting->threshold_trimester : null;
    $trimester = $setting->current_trimester;
    $year = $setting->current_year;


    // filter offering based on academic id
    $offerings = DB::table('offerings')
        ->join('courses', 'offerings.course_id', '=', 'courses.id')
        ->select('offerings.year AS Year', 'offerings.trimester AS Term', 'courses.code AS Course_Code', 'courses.name AS Course_Name')
        ->where('offerings.academic_id', $academic_id) // Filter by academic ID
        ->where('offerings.year', $year) // Filter by year
        ->where('offerings.trimester', $trimester) // Filter by trimester
        ->groupBy('offerings.year', 'offerings.trimester', 'courses.code', 'courses.name')
        ->get();
    return view('index', compact('threshold_trimester', 'name', 'offerings', 'department', 'setting'));
})->middleware(['auth', 'verified'])->name('view');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
