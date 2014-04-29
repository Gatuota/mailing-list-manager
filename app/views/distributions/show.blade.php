@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
List Details
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <h3>{{{ $distribution->name}}}</h3>
</div>

<div class="row">
    <div class="row">
      <div class="small-3 columns panel callout radius">
        <h4>Names</h4>
        <ul>
            <li>One</li>
            <li>Two</li>
            <li>Three</li>
        </ul>
      </div>
      <div class="small-6 columns">
        <p>
            <b>Reply Alias</b> {{{ $distribution->replyTo }}}
        </p>      
        <p>
            <b>Subject Template</b> {{{ $distribution->subject }}}
        </p>
        <p>
            <b>Body Template</b> <br /> {{{ $distribution->body }}}
        </p>
      </div>
      <div class="small-3 columns">
        <dl>
            <dt>Date Added</dt>
            <dl>{{{ $distribution->created_at }}}</dl>
        </dl>
        <button class="button small" type="button" onClick="location.href='{{ action('DistributionController@edit', array($distribution->id)) }}'">Edit</button>
        <button class="button small alert action_confirm" href="{{ action('ContactController@destroy', array($distribution->id)) }}" data-token="{{ Session::getToken() }}" data-method="delete">Delete</button>
      </div>
    </div>
</div>

@stop