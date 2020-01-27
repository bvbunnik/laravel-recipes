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


Route::get('/admin', 'AdminController@index');

Route::resource('course', 'CourseController');
Route::resource('cuisine', 'CuisineController');
Route::resource('unit', 'UnitController');
Route::resource('ingredient', 'IngredientController');
Route::get('recipes/import/', 'RecipeController@import_recipe');
Route::post('recipes/import', 'RecipeController@import');
Route::post('recipes/{id}/rate', 'RecipeController@rate');
Route::get('/recipes/favourites/', 'RecipeController@showFavourites');
Route::get('/recipes/toggle_favourite/{id}', 'RecipeController@toggleFavourite');
Route::get('/recipes/search', 'RecipeController@search');
Route::resource('recipes', 'RecipeController');
