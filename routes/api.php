<?php

use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\ExpertController;
use App\Http\Controllers\API\QueueController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\RoleController;
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
