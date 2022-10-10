<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SurveyFormController;
use App\Http\Controllers\SurveyTakerController;
use App\Http\Controllers\TakerAnswerController;
use App\Http\Controllers\UserController;

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
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('create-survey-form', [SurveyFormController::class, 'create']);
    Route::get('taker-list/{id}', [SurveyTakerController::class, 'list']);
    Route::get('form-list', [SurveyFormController::class, 'list']);
    Route::post('logout', [UserController::class, 'logout']);
});

Route::get('form/{id}', [SurveyFormController::class, 'view']);
Route::post('answer-survey/{id}', [SurveyTakerController::class, 'create']);
Route::get('survey_result/{id}', [TakerAnswerController::class, 'view']);
Route::get('all_survey_result/{id}', [TakerAnswerController::class, 'viewPerCourse']);

Route::post('login', [UserController::class, 'login']);
Route::post('signup', [UserController::class, 'signup']);
