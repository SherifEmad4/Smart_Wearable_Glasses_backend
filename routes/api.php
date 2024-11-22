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

Route::prefix('')->group(function () {
    // User Routes
    Route::resource('users', UserController::class);

    // Guardian Routes
    Route::resource('guardians', GuardianController::class);

    // Setting Routes
    Route::resource('settings', SettingController::class);

    // Location Routes
    Route::resource('locations', LocationController::class);

    // LocationHistory Routes
    Route::resource('location-histories', LocationHistoryController::class);

    // Message Routes
    Route::resource('messages', MessageController::class);

    // Image Routes
    Route::resource('images', ImageController::class);

    // Feedback Routes
    Route::resource('feedbacks', FeedbackController::class);

    // Feature Routes
    Route::resource('features', FeatureController::class);
});
Route::get('user',[UserController::class , 'show']);
Route::put('users',[UserController::class , 'update']);
Route::delete('users',[UserController::class , 'destroy']);

Route::get('feature',[FeatureController::class , 'show']);
Route::put('features',[FeatureController::class , 'update']);
Route::delete('features',[FeatureController::class , 'destroy']);

Route::get('setting',[SettingController::class , 'show']);
Route::put('settings',[SettingController::class , 'update']);
Route::delete('settings',[SettingController::class , 'destroy']);

Route::get('location',[LocationController::class , 'show']);
Route::put('locations',[LocationController::class , 'update']);
Route::delete('locations',[LocationController::class , 'destroy']);

Route::get('location-history',[LocationHistoryController::class , 'show']);
Route::delete('location-histories',[LocationHistoryController::class , 'destroy']);

Route::get('message',[MessageController::class , 'show']);
Route::put('messages',[MessageController::class , 'update']);
Route::delete('messages',[MessageController::class , 'destroy']);

Route::get('feedback',[FeedbackController::class , 'show']);
Route::put('feedbacks',[FeedbackController::class , 'update']);
Route::delete('feedbacks',[FeedbackController::class , 'destroy']);
