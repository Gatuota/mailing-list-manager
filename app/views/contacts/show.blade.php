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
            <dl>{{{ $contact->created_at }}}</dl>
        </dl>

        <a class="button small" href="{{ action('ContactController@edit', $contact->id) }}">Edit</a>
      </div>
    </div>
</div>

@stop