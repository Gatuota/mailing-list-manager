<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		@section('title') 
		@show 
	</title>

	<!-- If you are using CSS version, only link these 2 files, you may add app.css to use for your overrides if you like. -->
	<link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
	<link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
	<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

	<script src="{{ asset('js/vendor/modernizr.js') }}"></script>
	
</head>
<body>

	<nav class="top-bar" data-topbar>
		<ul class="title-area">
			<li class="name">
				<h1><a href="/">Mailing List Manager</a></h1>
			</li>
			<li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
		</ul>

		<section class="top-bar-section">
			<!-- Right Nav Section -->
			<ul class="right">
				 @if (Sentry::check())
					<li {{ (Request::is('users/show/' . Session::get('userId')) ? 'class="active"' : '') }}><a href="/users/{{ Session::get('userId') }}">{{ Session::get('email') }}</a></li>
					<li class="divider hide-for-small"></li>
					<li><a href="{{ URL::route('Sentinel\logout') }}">Logout</a></li>
					@else
					<li {{ (Request::is('login') ? 'class="active"' : '') }}><a href="{{ URL::route('Sentinel\login') }}">Login</a></li>
					<li class="divider hide-for-small"></li>
					<li {{ (Request::is('register') ? 'class="active"' : '') }}><a href="{{ URL::route('Sentinel\register') }}">Register</a></li>
				@endif
			</ul>

			<!-- Left Nav Section -->
			<ul class="left">
				<li class="divider hide-for-small"></li>
				<li {{ (Request::is('broadcast')  ? 'class="active"' : '') }}><a href="/#">Broadcast</a></li>
				<li class="divider hide-for-small"></li>
				<li {{ (Request::is('contacts*')  ? 'class="active"' : '') }}><a href="{{ action('ContactController@index') }}">Contacts</a></li>
				<li class="divider hide-for-small"></li>
				<li {{ (Request::is('distributions*')  ? 'class="active"' : '') }}><a href="/#">Lists</a></li>

				@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
					<li class="divider hide-for-small"></li>
					<li class="has-dropdown">
						<a href="#">Admin</a>
						<ul class="dropdown">
						  	<li {{ (Request::is('users*') ? 'class="active"' : '') }}><a href="{{ URL::action('Sentinel\UserController@index') }}">Users</a></li>
							<li {{ (Request::is('groups*') ? 'class="active"' : '') }}><a href="{{ URL::action('Sentinel\GroupController@index') }}">Groups</a></li>
						</ul>
					</li>
				@endif

			</ul>
		</section>
	</nav>

	<!-- Notifications -->
	@include('Sentinel::layouts/notifications')
	<!-- ./ notifications -->

	<!-- Content -->
	@yield('content')
	<!-- ./ content -->

	<script src="{{ asset('js/vendor/jquery.js') }}"></script>
	<script src="{{ asset('js/foundation.min.js') }}"></script>
	<script src="{{ asset('js/restfulizer.js') }}"></script>
	<script>
		$(document).foundation();
	</script>
</body>
</html>