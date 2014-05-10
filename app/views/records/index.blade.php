@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
Log
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<h3>Event Log</h3>
</div>

<div class="row">
	
	@if (count($records) > 0)
	<table class="full-width">
		<thead>
			<th>Date</th>
			<th>Event</th>
			<th>Details</th>
		</thead>
		<tbody>
			@foreach ($records as $record)
				<tr>
					<td>
						{{{ $record->created_at->format('D, M jS - G:H') }}}
					</td>
					<td>
						{{ ucfirst($record->event) }}
					</td>
					<td>
						<?php
							$details = json_decode($record->details);
							foreach ($details as $key => $value) 
							{
								if (is_array($value)) 
								{
									echo '<b>' . ucfirst($key) . ':</b> ' . (empty($value) ? 'None' : implode(",", $value)) . " ";
								}
								else 
								{
									echo '<b>' . ucfirst($key) . ':</b> ' . $value . " ";
								}
							}
						?>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	@else 
	<p>No records at this time.</p>
	@endif
</div>
<div class="row">
	{{ $records->links('layouts.pagination') }}
</div>

@stop
