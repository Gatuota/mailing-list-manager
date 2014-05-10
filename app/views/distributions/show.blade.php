@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
List Details
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="small-8 columns">
        <h3>{{{ $distribution->name}}}</h3>  
    </div>
    <div class="small-4 columns text-right">
        <button class="button small" type="button" onClick="location.href='{{ action('DistributionController@edit', array($distribution->id)) }}'">Edit</button>
        <button class="button small alert action_confirm" href="{{ action('ContactController@destroy', array($distribution->id)) }}" data-token="{{ Session::getToken() }}" data-method="delete">Delete</button>
    </div>
</div>

<div class="row">  
    <div class="small-4 columns panel callout radius">
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
    <div class="small-8 columns">
        <p>
            <span class="radius secondary label">Date Added: {{{ $distribution->created_at->format('F jS, Y h:ia') }}}</span>
            <span class="radius {{{ $distribution->trashed() ? 'alert' : 'secondary' }}} label">Status: {{{ $distribution->trashed() ? 'Disabled' : 'Active' }}}</span><br />
            <b>Reply Alias</b> <br />
            @if (! empty($distribution->replyName))
                {{{ $distribution->replyName }}} &lt;{{{ $distribution->replyTo }}}&gt;
            @else 
                {{{ $distribution->replyTo }}}
            @endif
        </p>      
        <p>
            <b>Subject Template</b> <br /> {{{ $distribution->subject }}}
        </p>
        <p>
            <b>Body Template</b> <br /> {{{ $distribution->body }}}
        </p>
        
        
    </div>
</div>


@stop