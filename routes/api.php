<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\Password\ForgetPasswordController;
use App\Http\Controllers\Auth\Password\OtpController;
use App\Http\Controllers\Auth\Password\ResetPasswordController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResumeOrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
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



// Portfolio
Route::post('/auth/login', [LoginController::class, 'login']);
Route::post('/auth/forgot-password', [ForgetPasswordController::class, 'send']);
Route::post('/auth/verify-otp', [OtpController::class, 'verify']);
Route::post('/auth/reset-password', [ResetPasswordController::class, 'reset']);
Route::post('/contact-us/store', [ContactUsController::class, 'store']);
Route::get('/user/data', [UserController::class, 'getUserData']);
// Services
Route::get('/service', [ServiceController::class, 'index']);
// Portfolio
Route::get('/portfolio', [ProjectController::class, 'index']);
Route::get('/portfolio/show/{id}', [ProjectController::class, 'show']);
// Settings
Route::get('/setting', [SettingController::class, 'index']);
// Teams
Route::get('/team', [TeamController::class, 'index']);
// Certification
Route::get('/certificate', [CertificateController::class, 'index']);
// Blog
Route::get('/blog', [BlogController::class, 'index']);
//Resume
Route::get('/resume', [ResumeOrderController::class, 'index']);
Route::get('/skill', [SkillController::class, 'index']);
Route::get('/experience', [ExperienceController::class, 'index']);
Route::get('/education', [EducationController::class, 'index']);



// Admin
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

Route::get('/user', [UserController::class, 'index']);
Route::delete('/auth/logout', [LoginController::class, 'logout']);
Route::put('/user/update', [UserController::class, 'update']);

    // Education
    Route::controller(EducationController::class)->prefix('education')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

    // Experience
    Route::controller(ExperienceController::class)->prefix('experience')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

    // Skills
    Route::controller(SkillController::class)->prefix('skill')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

    // Blog
    Route::controller(BlogController::class)->prefix('blog')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

    // Certifications
    Route::controller(CertificateController::class)->prefix('certification')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

    // Portfolio
    Route::controller(ProjectController::class)->prefix('portfolio')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

    // Settings
    Route::controller(SettingController::class)->prefix('setting')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::put('/update', 'update');
    });

    // Team
    Route::controller(TeamController::class)->prefix('team')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

    // Services
    Route::controller(ServiceController::class)->prefix('service')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

    // Resume Orders
    Route::controller(ResumeOrderController::class)->prefix('resume')->group(function () {
        Route::get('/', 'index');
        Route::put('/reorder', 'update');
    });

    // Contact Us
    Route::controller(ContactUsController::class)->prefix('contact-us')->group(function () {
        Route::get('/', 'index');
        Route::patch('/read/{id}', 'markRead');
        Route::delete('/delete/{id}', 'destroy');
    });
});
