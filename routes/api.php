<?php

use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\Admin\InstitutionPostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UserSide\DonationController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\SuccessStoryController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserSide\InstitutionController;
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

  //====================authenticated route
    Route::middleware(['auth:sanctum'])->group(function () {
    // Route::post('/send_verification',[EmailVerificationController::class,'sendVerificationEmail'])->name('verification.send');
        //Route::post('/resend',[EmailVerificationController::class,'resend']);
        Route::post('/logout',[LoginController::class,'logout']);
        Route::post('/change_password',[LoginController::class,'changePassword']);


       //--------donation related
        Route::get('/admin_donation',[AdminDonationController::class,'getDonation']);
        Route::get('/total_donation',[AdminDonationController::class,'getTotalDonation']);

        //-------start post or damaged institution post related---------

        Route::apiResource('/posts',InstitutionPostController::class);

        Route::delete('/delete_image/{id}',[InstitutionPostController::class,'deleteImage']);
        Route::post('/update_images',[InstitutionPostController::class,'updateImage']);
       //-------end post related---------------

        //news or success story related

        Route::apiResource('/news',SuccessStoryController::class);
        Route::delete('/delete_news_image/{id}',[SuccessStoryController::class,'deleteImage']);
        Route::post('/update_news_images',[SuccessStoryController::class,'updateImage']);

        // end news related
        Route::apiResource('/users',UserController::class);
    });
    //=================== end auth route  ========

      //--------area related --zone and region
      Route::apiResource('/regions',RegionController::class);
      Route::apiResource('/zones',ZoneController::class);


        ///////////////======verification and forgot password
        Route::get('/verify',[EmailVerificationController::class,'verify'])->name('verification.verify');
        //  ->middleware('signed');
        Route::post('/login',[LoginController::class,'login'])->middleware('verified');
        Route::post('/forgot',[ForgotPasswordController::class,'forgot']);
        Route::post('/reset/{token}',[ResetPasswordController::class,'resetPassword']);

        //------------------User Side Route start here
        Route::post('/user_donation',[DonationController::class,'saveDonation']);
        Route::get('/user_donation',[DonationController::class,'getDonation']);
        Route::get('/user_posts',[InstitutionController::class,'getInstitutions']);
        Route::get('/user_posts/{id}',[InstitutionController::class,'getPostDetail']);
        Route::get('/user_news',[InstitutionController::class,'getSuccessStories']);
        Route::get('/user_news/{id}',[InstitutionController::class,'getSuccessStoryDetail']);

        //route for both admin and user side
        Route::get('/total_donation',[AdminDonationController::class,'getTotalDonation']);
        Route::get('/words',[DonationController::class,'getWords']);


