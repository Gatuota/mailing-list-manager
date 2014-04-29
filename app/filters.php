<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Object Ownership Filter
|--------------------------------------------------------------------------
| 
| Check to see the object referenced by the URL belongs to the current user.
| 
*/

Route::filter('my', function($route, $request, $value)
{
	$repository = App::make('MLM\\Repositories\\' . ucfirst($value) . '\\' . ucfirst($value) . 'Interface');
	
	if ( ! $repository->mine(Route::input('id')) )
	{
		Session::flash('error', trans('Sentinel::users.noaccess'));
		return Redirect::route('home');
	}
	
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
