@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Home
@stop

{{-- Content --}}
@section('content')
<div class="row">
	<h4>Account Profile</h4>
	
	    <div class="small-6 columns">
		    @if ($user->first_name)
		    	<p><strong>First Name:</strong> {{ $user->first_name }} </p>
			@endif
			@if ($user->last_name)
		    	<p><strong>Last Name:</strong> {{ $user->last_name }} </p>
			@endif
		    <p><strong>Email:</strong> {{ $user->email }}</p>
		    
			<p>
				<em>
					Account created: {{ $user->created_at }} <br />
					Last Updated: {{ $user->updated_at }}
				</em>
			</p>
			<button class="button" onClick="location.href='{{ action('Sentinel\UserController@edit', array($user->id)) }}'">Edit Profile</button>
			<button class="button secondary" onClick="location.href='{{ action('RecordController@index') }}'">View Event Log</button>		
		</div>

		<div class="small-6 columns">
			<h4>Group Memberships:</h4>
			<?php $userGroups = $user->getGroups(); ?>
		    <ul>
		    	@if (count($userGroups) >= 1)
			    	@foreach ($userGroups as $group)
						<li>{{ $group['name'] }}</li>
					@endforeach
				@else 
					<li>No Group Memberships.</li>
				@endif
		    </ul>

		</div>
</div>

@stop
