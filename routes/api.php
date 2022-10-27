<?php

use App\Http\Controllers\Api\AssignedCareerController;
use App\Http\Controllers\Api\AttendaceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CareerController;
use App\Http\Controllers\Api\CenterController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\SemesterController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\StudentCourseController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\TeacherCourseAssignedController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\GraphicController;
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

Route::post('login', [AuthController::class, 'login']);

Route::name('api.')
    //->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('centers', CenterController::class);
        Route::apiResource('attendances', AttendaceController::class);
        Route::apiResource('careers', CareerController::class);
        Route::apiResource('assigned-careers', AssignedCareerController::class);
        Route::apiResource('students', StudentController::class);
        Route::apiResource('courses', CourseController::class);
        Route::apiResource('schedules', ScheduleController::class);
        Route::apiResource('teachers', TeacherController::class);
        Route::apiResource('semesters', SemesterController::class);
        Route::apiResource('sections', SectionController::class);
        Route::apiResource('student-courses', StudentCourseController::class);
        Route::apiResource('teacher-courses', TeacherCourseAssignedController::class);
        Route::get('courses-list/{id}', [CourseController::class, 'courses']);
        Route::get('student-courses-list/{id_student}',  [StudentCourseController::class, 'studentCourses']);
        Route::get('percentages/{id_student}',  [StudentCourseController::class, 'percentage']);
        Route::get('graphics', [DashboardController::class, 'index']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
