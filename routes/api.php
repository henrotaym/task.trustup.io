<?php

use App\Http\Controllers\Api\TaskController;
use Deegitalbe\ServerAuthorization\Http\Middleware\AuthorizedServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('tasks')->name('tasks.')->middleware(AuthorizedServer::class)->group(function () {
//     Route::post('/', [TaskController::class, 'store'])->name('store');
//     Route::get('/', [TaskController::class, 'index'])->name('index');
//     Route::put('/', [TaskController::class, 'store'])->name('store');
//     Route::destroy('/', [TaskController::class, 'index'])->name('index');
//     Route::show('/', [TaskController::class, 'index'])->name('index');
// });

Route::apiResource('tasks', TaskController::class)->middleware(AuthorizedServer::class);
