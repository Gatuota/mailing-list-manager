@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
Edit List
@stop

{{-- Content --}}
@section('content')
{{ Form::open(array('action' => array('DistributionController@update', $distribution->id), 'method' => 'put')) }}
  <div class="row">
        <div class="small-6 large-centered columns">
            <h3>Update {{{ $distribution->name }}}</h3>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Name</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('name')) ? 'error' : '' }}">
                    {{ Form::text('name', $distribution->name, array('placeholder' => 'Name', 'autofocus')) }}
                    {{ ($errors->has('name') ? $errors->first('name', '<small class="error">:message</small>') : '') }}
                </div>
            </div>
            
            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Reply To</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('replyTo')) ? 'error' : '' }}">
                    {{ Form::text('replyTo', $distribution->replyTo, array('placeholder' => 'E-Mail')) }}
                    {{ ($errors->has('replyTo') ? $errors->first('replyTo', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Subject</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('subject')) ? 'error' : '' }}">
                    {{ Form::text('subject', $distribution->subject, array('placeholder' => 'Subject Template')) }}
                    {{ ($errors->has('subject') ? $errors->first('subject', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Body</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('body')) ? 'error' : '' }}">
                    {{ Form::textarea('body', $distribution->body, array('placeholder' => 'Body Template')) }}
                    {{ ($errors->has('body') ? $errors->first('body', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Contacts</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('body')) ? 'error' : '' }}">
                    <select name="contacts[normal][]" class="contactsearch" placeholder="Name or Email" multiple="multiple">
                        @if (isset($contacts['normal']) && count($contacts['normal']) != 0)
                            @foreach($contacts['normal'] as $id => $contact)
                                <option value="{{{ $id }}}" data-data="{{{ json_encode($contact) }}}" selected>
                                    {{{ $contact['email'] }}}
                                </option>;
                            @endforeach
                        @endif
                    </select>
                
                    {{ ($errors->has('contacts[normal]') ? $errors->first('contacts[normal]', '<small class="error">:message</small>') : '') }}
                    
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">CC</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('body')) ? 'error' : '' }}">
                    <select name="contacts[cc][]" class="contactsearch" placeholder="Name or Email" multiple="multiple">
                        @if (isset($contacts['cc']) && count($contacts['cc']) != 0)
                            @foreach($contacts['cc'] as $id => $contact)
                                <option value="{{{ $id }}}" data-data="{{{ json_encode($contact) }}}" selected>
                                    {{{ $contact['email'] }}}
                                </option>;
                            @endforeach
                        @endif
                    </select>
                {{ ($errors->has('contacts[cc]') ? $errors->first('contacts[cc]', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">BCC</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('body')) ? 'error' : '' }}">
                    <select name="contacts[bcc][]" class="contactsearch" placeholder="Name or Email" multiple="multiple">
                        @if (isset($contacts['bcc']) && count($contacts['bcc']) != 0)
                            @foreach($contacts['bcc'] as $id => $contact)
                                <option value="{{{ $id }}}" data-data="{{{ json_encode($contact) }}}" selected>
                                    {{{ $contact['email'] }}}
                                </option>;
                            @endforeach
                        @endif
                    </select>
                {{ ($errors->has('contacts[bcc]') ? $errors->first('contacts[bcc]', '<small class="error">:message</small>') : '') }}
                    
                </div>
            </div>

            <div class="row">
                <div class="small-9 small-offset-3 columns">
                    {{ Form::hidden('redirect', URL::previous())}}
                    {{ Form::submit('Save', array('class' => 'button' )) }}
                </div>
            </div>
                       
        </div>
    </div>            
{{ Form::close() }}
@stop

@section('scripts')
    <script src="{{ asset('js/vendor/selectize.min.js') }}"></script>
    <script>
            var REGEX_EMAIL = '([a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@' +
                  '(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)';
            $('.contactsearch').selectize({
                // Tell Selectize to use a remote data source for the autosuggest options
                plugins: ['remove_button'],
                persist: false,
                maxItems: null,
                valueField: 'id',
                labelField: 'name',
                dataAttr: 'data-data',
                searchField: ['displayName', 'email'],
                render: {
                    item: function(item, escape) {
                        console.log('item');
                        console.log(item);
                        var title = item.displayName || item.email;
                        return '<div>' +
                            '<span class="contact_item">' + 
                            (item.displayName.replace(/^[\s\t]+/,"").length  != 0 ? escape(item.displayName) : escape(item.email) ) + 
                            '</span></div>';
                    },
                    option: function(item, escape) {
                        console.log(item);
                        return '<div>' +
                            '<span class="option_item">' + 
                            (item.displayName.replace(/^[\s\t]+/,"").length  != 0 ? escape(item.displayName) : escape(item.email) ) + 
                            '</span></div>';
                    }
                },
                load: function(query, callback) {
                    // Load options via AJAX
                    $.ajax({
                        // Send a GET or POST request providing "query" as the data
                        // When data is retrieved, execute callback() on that data to
                        // refresh the list of autosuggest options
                        url: '/ajax/contacts/search',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            q: query
                        },
                        success: function(data) {
                            callback(data);
                        }
                    }); 
                },
                create: function(input) {
                    if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
                        return {email: input, id: input, displayName: ' '};
                    }
                    var match = input.match(new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i'));                 
                    if (match) {
                        console.log(match);
                        return {
                            email : match[2],
                            name  : $.trim(match[1]),
                            id    : match[2]
                        };
                    }
                    alert('Invalid email address.');
                    return false;
                }

            });


    </script>
@stop 

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/selectize/selectize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/selectize/selectize.custom.css') }}">
@stop