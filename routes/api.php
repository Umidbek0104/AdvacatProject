<?php

use App\Http\Controllers\API\AdminPageController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\ExpertController;
use App\Http\Controllers\API\QueueController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'appointments' => AppointmentController::class,
    'clients' => ClientController::class,
    'experts' => ExpertController::class,
    'queues' => QueueController::class,
    'reviews' => ReviewController::class,
    'roles' => RoleController::class,
]);


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
Route::get('/dashboard', [AdminPageController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('submit/profile', [UserController::class, 'submitProfile']);
});


Route::post('/submit-profile', [UserController::class, 'store']);
Route::get('/admin/index',[AdminPageController::class,'index']);
Route::prefix('admin')->group(function () {
    Route::get('/users/pending', [AdminPageController::class, 'pendingProfiles']);
    Route::post('/users/{id}/approve', [AdminPageController::class, 'approveProfile']);
    Route::post('/users/{id}/reject', [AdminPageController::class, 'rejectProfile']);
});
