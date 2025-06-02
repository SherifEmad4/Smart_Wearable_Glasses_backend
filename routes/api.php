<?php

use App\Http\Controllers\Api\FeatureController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\GuardianController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\LocationHistoryController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserGuardianController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/test-api', function () {
//     return response()->json(['message' => 'API is working!']);
// });


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
Route::post('auth/register', [RegisterController::class, 'register']);

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    // Route::post('register', [RegisterController::class, 'register'])->name('register');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout']);
});

// Route::middleware('isAdmin')->group(function () {
    // # Users Routes #
    Route::get('users',[UserController::class, 'index']);
    Route::post('users',[UserController::class, 'store']);
    Route::get('user',[UserController::class , 'show']);
    Route::put('users',[UserController::class , 'update']);
    Route::delete('users',[UserController::class , 'destroy']);
    //Route::middleware(['auth:sanctum', 'isAdmin'])->get('/admin/profile', [LoginController::class, 'profile']);
    Route::post('connect-guardian', [GuardianController::class, 'connectGuardian']);


    // # Settings Routes
    Route::get('settings',[SettingController::class, 'index']);
    Route::delete('settings',[SettingController::class , 'destroy']);

    // # Locations Routes #
    Route::get('get-locations',[LocationController::class, 'index']);
    Route::put('update-locations',[LocationController::class , 'update']);
    Route::delete('delete-locations',[LocationController::class , 'destroy']);

    // # Location History Routes #
    Route::get('get-location-histories',[LocationHistoryController::class, 'index']);
    Route::delete('delete-location-histories',[LocationHistoryController::class , 'destroy']);

    // # Messages Routes #
    Route::get('messages',[MessageController::class, 'index']);
    Route::post('messages',[MessageController::class, 'store']);
    Route::get('message',[MessageController::class , 'show']);
    Route::put('messages',[MessageController::class , 'update']);
    Route::delete('messages',[MessageController::class , 'destroy']);

    // # Images Routes #
    Route::get('images',[ImageController::class, 'index']);
    Route::delete('images',[ImageController::class, 'destroy']);

    // # FeedBack Routes #
    Route::get('feedbacks',[FeedbackController::class, 'index']);
    Route::get('feedback',[FeedbackController::class , 'show']);
    Route::put('feedbacks',[FeedbackController::class , 'update']);
    Route::delete('feedbacks',[FeedbackController::class , 'destroy']);

    // # Features Routes #
    Route::get('features',[FeatureController::class, 'index']);
    Route::post('features',[FeatureController::class, 'store']);
    Route::get('feature',[FeatureController::class , 'show']);
    Route::put('features',[FeatureController::class , 'update']);
    Route::delete('features',[FeatureController::class , 'destroy']);

    // # User Guardians Routes #
    Route::get('user-guardians', [UserGuardianController::class, 'index']);
    Route::post('user-guardians', [UserGuardianController::class, 'store']);
    Route::get('user-guardian', [UserGuardianController::class, 'show']);
    Route::put('user-guardians', [UserGuardianController::class, 'update']);
    Route::delete('user-guardians', [UserGuardianController::class, 'destroy']);
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('')->group(function () {
//     // User Routes
//     Route::resource('users', UserController::class);

//     // Setting Routes
//     Route::resource('settings', SettingController::class);

//     // Location Routes
//     Route::resource('locations', LocationController::class);

//     // LocationHistory Routes
//     Route::resource('location-histories', LocationHistoryController::class);

//     // Message Routes
//     Route::resource('messages', MessageController::class);

//     // Image Routes
//     Route::resource('images', ImageController::class);

//     // Feedback Routes
//     Route::resource('feedbacks', FeedbackController::class);

//     // Feature Routes
//     Route::resource('features', FeatureController::class);
// });



// # Features Routes #


// # Settings Routes #
Route::post('settings',[SettingController::class, 'store']);
Route::get('setting',[SettingController::class , 'show']);
Route::put('settings',[SettingController::class , 'update']);


// # Locations Routes #
Route::post('create-locations',[LocationController::class, 'store']);
Route::get('get-location',[LocationController::class , 'show']);


// # Location History Routes #
Route::post('create-location-histories',[LocationHistoryController::class, 'store']);
Route::get('get-location-history',[LocationHistoryController::class , 'show']);

# Messages Routes #


// # FeedBack Routes #
Route::post('feedbacks',[FeedbackController::class, 'store']);


// # Images Routes #
Route::post('images',[ImageController::class, 'store']);
Route::get('image',[ImageController::class, 'show']);


// # User Guardians Routes #
//youssef


// Route::middleware('auth.jwt')->group(function () {
//     Route::get('/users', [UserController::class, 'index']);
//     Route::post('/users/update', [UserController::class, 'update']);
// });

