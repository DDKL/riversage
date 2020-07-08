<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('survey','SurveyAPI@getSurveys');
//Route::get('survey/{cat}','SurveyAPI@getSurvey');
Route::get('survey/{sid}','SurveyAPI@getSurvey');
Route::post('survey/{sid}','SurveyAPI@postSurvey');

Route::get('result/{users_id}','ResultAPI@getAllResults');
Route::get('result/{users_id}/{rid}','ResultAPI@getResult');

Route::get('users','UsersAPI@getUsers');
Route::get('users/{users_id}','UsersAPI@getUser');
Route::post('users','UsersAPI@addUser');
Route::put('users/{users_id}','UsersAPI@editUser');