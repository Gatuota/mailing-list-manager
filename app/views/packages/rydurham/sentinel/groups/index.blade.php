@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Groups
@stop

{{-- Content --}}
@section('content')
<div class="row">
	<h4>Available Groups</h4>
	<table class="full-width">
		<thead>
			<th>Name</th>
			<th>Permissions</th>
			<th>Options</th>
		</thead>
		<tbody>
		@foreach ($groups as $group)
			<tr>
				<td><a href="groups/{{ $group->id }}">{{ $group->name }}</a></td>
				<td>{{ (isset($group['permissions']['admin'])) ? '<i class="icon-ok"></i> Admin' : ''}} {{ (isset($group['permissions']['users'])) ? '<i class="icon-ok"></i> Users' : ''}}</td>
				<td>
					<button class="button small" onClick="location.href='{{ action('Sentinel\GroupController@edit', array($group->id)) }}'">Edit</button>
				 	<button class="button small action_confirm {{ ($group->id == 2) ? 'disabled' : '' }}" type="button" data-token="{{ Session::getToken() }}" data-method="delete" href="{{ URL::action('Sentinel\GroupController@destroy', array($group->id)) }}">Delete</button>
				 </td>
			</tr>	
		@endforeach
		</tbody>
	</table> 

	 <button class="button" onClick="location.href='{{ URL::action('Sentinel\GroupController@create') }}'">New Group</button>
</div>

<!--  
	The delete button uses Resftulizer.js to restfully submit with "Delete".  The "action_confirm" class triggers an optional confirm dialog.
	Also, I have hardcoded adding the "disabled" class to the Admin group - deleting your own admin access causes problems.
-->
@stop

