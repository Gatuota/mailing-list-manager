@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
New List
@stop

{{-- Content --}}
@section('content')
{{ Form::open(array('action' => 'DistributionController@store')) }}
  <div class="row">
        <div class="small-6 large-centered columns">
            <h3>New List</h3>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Name</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('name')) ? 'error' : '' }}">
                    {{ Form::text('name', null, array('placeholder' => 'Name', 'autofocus')) }}
                    {{ ($errors->has('name') ? $errors->first('name', '<small class="error">:message</small>') : '') }}
                </div>
            </div>
            
            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Reply To</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('replyTo')) ? 'error' : '' }}">
                    {{ Form::text('replyTo', null, array('placeholder' => 'E-Mail')) }}
                    {{ ($errors->has('replyTo') ? $errors->first('replyTo', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Subject</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('subject')) ? 'error' : '' }}">
                    {{ Form::text('subject', null, array('placeholder' => 'Subject Template')) }}
                    {{ ($errors->has('subject') ? $errors->first('subject', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Body</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('body')) ? 'error' : '' }}">
                    {{ Form::textarea('body', null, array('placeholder' => 'Body Template')) }}
                    {{ ($errors->has('body') ? $errors->first('body', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-9 small-offset-3 columns">
                    {{ Form::submit('Save', array('class' => 'button' )) }}
                </div>
            </div>
                       
        </div>
    </div>            
{{ Form::close() }}

@stop