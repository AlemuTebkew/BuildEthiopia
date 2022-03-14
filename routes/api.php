<?php

use App\Http\Controllers\Admin\InstitutionPostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\InstitutionPost;
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

Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/send_verification',[EmailVerificationController::class,'sendVerificationEmail'])->name('verification.send');
    Route::post('/resend',[EmailVerificationController::class,'resend']);
    Route::post('/logout',[LoginController::class,'logout']);
});
Route::post('/verify',[EmailVerificationController::class,'verify'])
                              ->name('verification.verify')
                            //   ->middleware('signed')
                              ;

Route::post('/login',[LoginController::class,'login']);
Route::post('/forgot',[ForgotPasswordController::class,'forgot']);
Route::post('/reset',[ForgotPasswordController::class,'reset']);

Route::apiResource('/posts',InstitutionPostController::class);
Route::apiResource('/users',UserController::class);
Route::apiResource('/regions',RegionController::class);
Route::apiResource('/zones',ZoneController::class);
