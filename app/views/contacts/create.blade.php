@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
New Contact
@stop

{{-- Content --}}
@section('content')
{{ Form::open(array('action' => 'ContactController@store')) }}
  <div class="row">
        <div class="small-6 large-centered columns">
            <h3>New Contact</h3>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">First Name</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('firstName')) ? 'error' : '' }}">
                    {{ Form::text('firstName', null, array('placeholder' => 'First Name', 'autofocus')) }}
                    {{ ($errors->has('firstName') ? $errors->first('firstName', '<small class="error">:message</small>') : '') }}
                </div>
            </div>
            
            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Middle Name</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('middleName')) ? 'error' : '' }}">
                    {{ Form::text('middleName', null, array('placeholder' => 'Middle Name')) }}
                    {{ ($errors->has('middleName') ? $errors->first('middleName', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Last Name</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('lastName')) ? 'error' : '' }}">
                    {{ Form::text('lastName', null, array('placeholder' => 'Last Name')) }}
                    {{ ($errors->has('lastName') ? $errors->first('lastName', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">E-Mail</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('email')) ? 'error' : '' }}">
                    {{ Form::email('email', null, array('placeholder' => 'E-Mail')) }}
                    {{ ($errors->has('email') ? $errors->first('email', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Phone</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('phone')) ? 'error' : '' }}">
                    {{ Form::text('phone', null, array('placeholder' => 'Phone', 'type' => 'tel')) }}
                    {{ ($errors->has('phone') ? $errors->first('phone', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Note</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('notes')) ? 'error' : '' }}">
                    {{ Form::textarea('notes', null, array('placeholder' => '...')) }}
                    {{ ($errors->has('notes') ? $errors->first('notes', '<small class="error">:message</small>') : '') }}
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