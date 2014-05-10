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

// Distribution Routes
Route::get('distributions', 'DistributionController@index');
Route::get('distributions/new', 'DistributionController@create');
Route::post('distributions', 'DistributionController@store');
Route::get('distributions/{id}', 'DistributionController@show');
Route::get('distributions/{id}/edit', 'DistributionController@edit');
Route::put('distributions/{id}', 'DistributionController@update');
Route::put('distributions/{id}/deactivate', 'DistributionController@deactivate');
Route::put('distributions/{id}/activate', 'DistributionController@activate');
Route::delete('distributions/{id}/destroy', 'DistributionController@destroy');

//Broadcast Routes
Route::get('broadcast', 'BroadcastController@create');
Route::get('broadcast/show', function()
{
	return Redirect::to('broadcast');
});
Route::post('broadcast/show', 'BroadcastController@show');

// Ajax Routes
Route::group(array('prefix' => 'ajax'), function()
{
    // Contacts
    Route::get('contacts/search', 'ContactController@ajaxSearch');
    Route::post('broadcast/upload', 'BroadcastController@upload');
    Route::post('broadcast/send', 'BroadcastController@send');
});