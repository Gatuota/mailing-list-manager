@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
Contact Details
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <h3>{{{ $contact->firstName}}} {{{ $contact->middleName }}} {{{ $contact->lastName }}}</h3>
</div>

<div class="row">
    <div class="row">
      <div class="large-3 columns">
        <img src="<?= Gravatar::src($contact->email, 230) ?>">
      </div>
      <div class="large-6 columns">
        <dl>
            <dt>E-mail</dt>
            <dd>{{{ $contact->email }}}</dt>
        </dl>
        <dl>
            <dt>Phone</dt>
            <dd>{{{ $contact->phone }}}</dd>
        </dl>
        <dl>
            <dt>Notes</dt>
            <dd>{{{ $contact->notes }}}</dd>
        </dl>
      </div>
      <div class="large-3 columns">
        <dl>
            <dt>Date Added</dt>
            <dl>{{{ $contact->created_at->format('F jS, Y h:ia')  }}}</dl>
        </dl>

        <button class="button small" href="{{ action('ContactController@edit', $contact->id) }}">Edit</button>
        <button class="button small alert action_confirm" href="{{ action('ContactController@destroy', array($contact->id)) }}" data-token="{{ Session::getToken() }}" data-method="delete">Delete</button>
      </div>
    </div>
</div>

@stop