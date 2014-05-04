@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
Lists
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<div class="small-6 columns">
		<h3>Your Lists</h3>
	</div>
	<div class="small-6 columns">
		<a class="button right" href="{{ action('DistributionController@create') }}">New List</a>
	</div>
</div>

<div class="row">
	
	<table class="full-width">
		<thead>
			<th>Name</th>
			<th>Reply Alias</th>
			<th>Contacts</th>
			<th>Options</th>
		</thead>
		<tbody>
			@foreach ($distributions as $distribution)
				<tr>
					<td {{ ( $distribution->trashed() ? "class='strikethrough'" : " " ) }}>
						<a href="{{ action('DistributionController@show', $distribution->id) }}">{{{ $distribution->name }}}</a>
					</td>
					<td {{ ( $distribution->trashed() ? "class='strikethrough'" : " " ) }}>
						{{ $distribution->replyTo }}</td>
					<td {{ ( $distribution->trashed() ? "class='strikethrough'" : " " ) }}>

					</td>
					<td>
						<button class="button small" type="button" onClick="location.href='{{ action('DistributionController@edit', array($distribution->id)) }}'">Edit</button>
						@if (! $distribution->trashed())
							<button class="button small action_confirm" type="button" href="{{ action('DistributionController@deactivate', array($distribution->id)) }}" data-token="{{ Session::getToken() }}" data-method="put">Deactivate</button> 
						@else 
							<button class="button small action_confirm" type="button" href="{{ action('DistributionController@activate', array($distribution->id)) }}" data-token="{{ Session::getToken() }}" data-method="put">Activate</button>
						@endif
						<button class="button small alert action_confirm" href="{{ action('DistributionController@destroy', array($distribution->id)) }}" data-token="{{ Session::getToken() }}" data-method="delete">Delete</button>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div class="row">
	{{ $distributions->links('layouts.pagination') }}
</div>

@stop
