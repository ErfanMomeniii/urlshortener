<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UrlsController;
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
Route::middleware(['auth.api'])->group(function () {
    Route::post('url', [UrlsController::class, 'store']);
    Route::get('url/{code}', [UrlsController::class, 'showByCode']);
}
);

Route::post('user/register', [AuthController::class, 'register']);
Route::post('user/login', [AuthController::class, 'login']);
