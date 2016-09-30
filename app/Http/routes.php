<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'RecipeController@index');

Route::auth();

Route::get('/admin', 'AdminController@index');

Route::resource('course', 'CourseController');
Route::resource('cuisine', 'CuisineController');
Route::resource('unit', 'UnitController');
Route::resource('ingredient', 'IngredientController');
Route::get('recipes/import/', function () {
    return view('recipes.import');
});
Route::post('recipes/import', 'RecipeController@import');
Route::post('recipes/{id}/rate', 'RecipeController@rate');
Route::resource('recipes', 'RecipeController');
