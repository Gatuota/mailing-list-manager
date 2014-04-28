@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
Contacts
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<div class="small-6 columns">
		<h3>Your Contacts</h3>
	</div>
	<div class="small-6 columns">
		<a class="button small right" href="{{ action('ContactController@create') }}">New Contact</a>
	</div>
</div>

<div class="row">
	
	<table class="full-width">
		<thead>
			<th>Name</th>
			<th>Email</th>
			<th>Options</th>
		</thead>
		<tbody>
			@foreach ($contacts as $contact)
				<tr>
					<td><a href="{{ action('ContactController@show', $contact->id) }}">{{{ $contact->firstName . " " . $contact->middleName . " " . $contact->lastName }}}</a></td>
					<td>{{{ $contact->email }}}</td>
					<td></td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>


@stop
