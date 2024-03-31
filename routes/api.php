<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileTypeController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\WhyWorkWithUsController;
use App\Http\Controllers\KeyResponsibilitiesController;
use App\Http\Controllers\ReviewCompanyController;
use App\Http\Controllers\UserCVController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\SolveProblemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\UserExperienceController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'user'], function () {
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::put('/update', [UserController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/profile-types', [ProfileTypeController::class, 'index']);
        Route::post('/profile-types', [ProfileTypeController::class, 'store']);
        Route::put('/profile-types/{id}', [ProfileTypeController::class, 'update']);
        Route::delete('/profile-types/{id}', [ProfileTypeController::class, 'destroy']);
    });
    Route::prefix('companies')->group(function () {
        Route::get('/', [CompanyController::class, 'index']);
        Route::post('/', [CompanyController::class, 'store']);
        Route::get('/{id}', [CompanyController::class, 'show']);
        Route::put('/{id}', [CompanyController::class, 'update']);
        Route::delete('/{id}', [CompanyController::class, 'destroy']);
    });
    Route::prefix('experiences')->group(function () {
        Route::get('/', [ExperienceController::class, 'index']);
        Route::post('/', [ExperienceController::class, 'store']);
        Route::get('/{id}', [ExperienceController::class, 'show']);
        Route::put('/{id}', [ExperienceController::class, 'update']);
        Route::delete('/{id}', [ExperienceController::class, 'destroy']);
    });
    Route::prefix('user-experiences')->group(function () {
        Route::get('/', [UserExperienceController::class, 'index']);
        Route::post('/', [UserExperienceController::class, 'store']);
        Route::put('/{id}', [UserExperienceController::class, 'update']);
        Route::delete('/{id}', [UserExperienceController::class, 'destroy']);
    });
    Route::prefix('jobs')->group(function () {
        Route::get('/', [JobController::class, 'index']);
        Route::post('/', [JobController::class, 'store']);
        Route::get('/{id}', [JobController::class, 'show']);
        Route::put('/{id}', [JobController::class, 'update']);
        Route::delete('/{id}', [JobController::class, 'destroy']);
    });
    Route::prefix('why-work-with-us')->group(function () {
        Route::get('/', [WhyWorkWithUsController::class, 'index']);
        Route::post('/', [WhyWorkWithUsController::class, 'store']);
        Route::put('/{id}', [WhyWorkWithUsController::class, 'update']);
        Route::delete('/{id}', [WhyWorkWithUsController::class, 'destroy']);
    });
    Route::prefix('key-responsibilities')->group(function () {
        Route::get('/', [KeyResponsibilitiesController::class, 'index']);
        Route::post('/', [KeyResponsibilitiesController::class, 'store']);
        Route::put('/{id}', [KeyResponsibilitiesController::class, 'update']);
        Route::delete('/{id}', [KeyResponsibilitiesController::class, 'destroy']);
    });
    Route::prefix('reviews')->group(function () {
        Route::get('/{company_id}', [ReviewCompanyController::class, 'index']);
        Route::post('/', [ReviewCompanyController::class, 'store']);
        Route::get('/show/{review}', [ReviewCompanyController::class, 'show']);
        Route::put('/update/{review}', [ReviewCompanyController::class, 'update']);
        Route::delete('/delete/{review}', [ReviewCompanyController::class, 'destroy']);
    });
    Route::prefix('cvs')->group(function () {
        Route::get('/jobs/{job_id}/user-cvs', [UserCVController::class, 'index']);
        Route::post('/user-cvs', [UserCVController::class, 'store']);
        Route::get('/user-cvs/{userCV}', [UserCVController::class, 'show']);
        Route::put('/user-cvs/{userCV}', [UserCVController::class, 'update']);
        Route::delete('/user-cvs/{userCV}', [UserCVController::class, 'destroy']);
    });
    Route::prefix('problems')->group(function () {
        Route::get('/problems', [ProblemController::class, 'index']);
        Route::get('/problems/{problem}', [ProblemController::class, 'show']);
        Route::post('/problems', [ProblemController::class, 'store']);
        Route::put('/problems/{problem}', [ProblemController::class, 'update']);
        Route::delete('/problems/{problem}', [ProblemController::class, 'destroy']);
    });
    Route::prefix('solves')->group(function () {
        Route::post('/solveproblems', [SolveProblemController::class, 'store']);
        Route::get('/solveproblems/{problem_id}', [SolveProblemController::class, 'show']);
        Route::put('/solveproblems/{solveProblem}', [SolveProblemController::class, 'update']);
        Route::delete('/solveproblems/{solveProblem}', [SolveProblemController::class, 'destroy']);
    });
    Route::prefix('categories')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    });
    Route::prefix('articles')->group(function () {
        Route::get('/articles', [ArticleController::class, 'index']);
        Route::post('/articles', [ArticleController::class, 'store']);
        Route::get('/articles/{article}', [ArticleController::class, 'show']);
        Route::put('/articles/{article}', [ArticleController::class, 'update']);
        Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);
    });
    Route::prefix('resources')->group(function () {
        Route::get('/resources', [ResourceController::class, 'index']);
        Route::post('/resources', [ResourceController::class, 'store']);
        Route::get('/resources/{resource}', [ResourceController::class, 'show']);
        Route::put('/resources/{resource}', [ResourceController::class, 'update']);
        Route::delete('/resources/{resource}', [ResourceController::class, 'destroy']);
    });
});
Route::group(['prefix' => 'auth'], function () {
    Route::get('/google/redirect', [SocialAuthController::class, 'redirectToGoogle']);
    Route::get('/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
    Route::get('/facebook/redirect', [SocialAuthController::class, 'redirectToFacebook']);
    Route::get('/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);
});
