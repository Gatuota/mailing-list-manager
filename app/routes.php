<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route Patterns
Route::pattern('id', '[0-9]+');

// Set Home Route
 Route::get('/', array('as' => 'home', function()
{
    return View::make('hello');
}));

// Contact Routes
Route::get('contacts', 'ContactController@index');
Route::get('contacts/new', 'ContactController@create');
Route::post('contacts', 'ContactController@store');
Route::get('contacts/{id}', 'ContactController@show');
Route::get('contacts/{id}/edit', 'ContactController@edit');
Route::put('contacts/{id}', 'ContactController@update');
Route::delete('contacts/{id}', 'ContactController@destroy');
