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
        @if (count($distribution->contacts) != 0)
            <ul>
                @foreach ($distribution->contacts as $contact)
                    <li>
                        <?php $displayName = $contact->firstName . ' ' . $contact->middleName . ' ' . $contact->lastName;?>
                        @if (! empty(trim($displayName)))
                            {{{ $displayName }}}
                        @else
                            {{{$contact->email}}}
                        @endif
                        @if ($contact->pivot->method != 'normal')
                            {{{ "- " . strtoupper($contact->pivot->method) }}}
                        @endif
                    </li>
                @endforeach
            </ul>
        @else 
            <p>No Contacts</p>
        @endif
      </div>
      <div class="small-6 columns">
        <p>
            <b>Reply Alias</b> 
            @if (! empty($distribution->replyName))
                {{{ $distribution->replyName }}} &lt;{{{ $distribution->replyTo }}}&gt;
            @else 
                {{{ $distribution->replyTo }}}
            @endif
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
            <dd>{{{ $distribution->created_at->format('F jS, Y h:ia') }}}</dd>
        </dl>
        <dl>
            <dt>Status</dt>
            @if ($distribution->trashed())
                <dd>Disabled</dd>
            @else
                <dd>Active</dd>
            @endif
        </dl>
        
        <button class="button small" type="button" onClick="location.href='{{ action('DistributionController@edit', array($distribution->id)) }}'">Edit</button>
        <button class="button small alert action_confirm" href="{{ action('ContactController@destroy', array($distribution->id)) }}" data-token="{{ Session::getToken() }}" data-method="delete">Delete</button>
      </div>
    </div>
</div>

@stop