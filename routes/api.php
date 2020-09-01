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

// survey
Route::get('survey','SurveyAPI@getSurveys');
//Route::get('survey/{cat}','SurveyAPI@getSurvey');
Route::get('survey/{sid}','SurveyAPI@getSurvey');
Route::post('survey/{sid}','SurveyAPI@postSurvey');

// result
Route::get('result/{uid}','ResultAPI@getAllResults');
Route::get('result/{uid}/{rid}','ResultAPI@getResult');
Route::get('tally/{uid}','ResultAPI@getResultTally');

// user
Route::get('users','UsersAPI@getUsers');
Route::get('users/{uid}','UsersAPI@getUser');
Route::get('usersid/{uid}','UsersAPI@getUsersId');
Route::post('users','UsersAPI@addUser');
Route::put('users/{uid}','UsersAPI@editUser');
Route::delete('users/{uid}','UsersAPI@deleteUser');

// category
Route::get('categories', 'CategoriesAPI@getCategories');
Route::get('categories/{cid}', 'CategoriesAPI@getSubCategories');

// nutrients
Route::get('nutrients', 'NutrientsAPI@getAllNutrients');
Route::get('nutrients/{nid}', 'NutrientsAPI@getNutrient');
Route::get('benefits/{nid}', 'NutrientsAPI@getBenefits');
Route::get('risks/{nid}', 'NutrientsAPI@getRisks');

// products-kb
Route::get('kb/products/{ix}', 'KBase@getFeaturedProducts');