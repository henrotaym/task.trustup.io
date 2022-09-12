<?php

use App\Http\Controllers\Api\MediaModelController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('media')->name('media.')->middleware(AuthorizedServer::class)->group(function () {
    Route::post('/', [MediaModelController::class, 'store'])->name('store');
    Route::get('/', [MediaModelController::class, 'index'])->name('index');
});
