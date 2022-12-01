<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProjectController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::get('/users/search', [UserController::class, 'search']);

Route::get('/info', [InfoController::class, 'info']);

Route::get('/plans', [PlanController::class, 'index']);
Route::get('/plans/{plan}', [PlanController::class, 'show']);

Route::get('/users/{user}', [UserController::class, 'show']);
Route::get('/users/{user}/projects', [UserController::class, 'doctorProjects']);

Route::get('/companies/{user}/projects', [UserController::class, 'companyProjects']);

Route::get('/projects/{project}', [ProjectController::class, 'show']);

Route::get('/special/doctors-and-companies', [UserController::class, 'specialDoctorsAndCompanies']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/users/{user}/projects/create', [ProjectController::class, 'store']);
    Route::delete('/projects/{project}/delete', [ProjectController::class, 'destroy']);
    Route::post('/projects/{project}/update', [ProjectController::class, 'update']);

    Route::post('/users/{user}/update', [UserController::class, 'update']);
    Route::put('/users/{user}/change-coords', [UserController::class, 'changeCoords']);
    Route::put('/users/{user}/change-password', [UserController::class, 'changePassword']);
    Route::post('/users/{user}/request-change-plan', [UserController::class, 'requestChangePlan']);



    Route::middleware('is_admin')->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::get('/users', [UserController::class, 'index']);
            Route::post('/users/delete', [UserController::class, 'destroy']);
            Route::put('/users/pay', [UserController::class, 'renewSubscription']);
            Route::put('/users/{user}/activate', [UserController::class, 'activate']);
            Route::get('/users/requests', [UserController::class, 'requests']);
            Route::get('/users/unsubscribed', [UserController::class, 'unsubscribedUsersCount']);
            Route::post('/users/change-plan/{changePlanRequest}', [UserController::class, 'changePlan']);
            Route::delete('/users/reject-change-plan/{changePlanRequest}', [UserController::class, 'rejectChangePlan']);

            Route::prefix('/info')->group(function () {
                Route::put('/en/update', [InfoController::class, 'saveEN']);
                Route::put('/contact/update', [InfoController::class, 'saveContacts']);
                Route::put('/ar/update', [InfoController::class, 'saveAR']);
            });

        });

        Route::prefix('/plans')->group(function () {
            Route::post('/create', [PlanController::class, 'store']);
            Route::post('/delete', [PlanController::class, 'destroy']);
            Route::put('/{plan}/update', [PlanController::class, 'update']);
        });
    });

});
