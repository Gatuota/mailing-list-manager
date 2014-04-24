@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Edit Profile
@stop

{{-- Content --}}
@section('content')

{{ Form::open(array(
    'action' => array('Sentinel\UserController@update', $user->id), 
    'method' => 'put',
    'class' => 'form-horizontal', 
    'role' => 'form'
    )) }}

    <div class="row">
        <div class="small-6 large-centered columns">

            <h3>Edit 
            @if ($user->email == Sentry::getUser()->email)
                Your
            @else 
                {{ $user->email }}'s 
            @endif 
            Profile</h3>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">First Name</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('firstName')) ? 'error' : '' }}">
                    {{ Form::text('firstName', $user->first_name, array('placeholder' => 'First Name')) }}
                    {{ ($errors->has('firstName') ? $errors->first('firstName', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Last Name</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('lastName')) ? 'error' : '' }}">
                    {{ Form::text('lastName', $user->last_name, array('placeholder' => 'Last Name')) }}
                    {{ ($errors->has('lastName') ? $errors->first('lastName', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            @if (Sentry::getUser()->hasAccess('admin'))
            <div class="row">
                {{ Form::label('edit_memberships', 'Group Memberships') }}   
                @foreach ($allGroups as $group)
                    <div class="small-9 small-offset-3 columns">
                        <input type="checkbox" name="groups[{{ $group->id }}]" value='1' 
                        {{ (in_array($group->name, $userGroups) ? 'checked="checked"' : '') }} > {{ $group->name }}
                    </div>
                @endforeach
            </div>
            @endif

            <div class="row">
                <div class="small-9 small-offset-3 columns">
                    {{ Form::hidden('id', $user->id) }}
                    {{ Form::submit('Submit Changes', array('class' => 'button')) }}
                </div>
            </div>
        </div>
    </div>
{{ Form::close()}}

{{ Form::open(array(
        'action' => array('Sentinel\UserController@change', $user->id), 
        'class' => 'form-inline', 
        'role' => 'form'
        )) }}
    <div class="row">
        <div class="small-6 large-centered columns">
            <h4>Change Password</h4>    
    
            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Current</label>
                </div>
                <div class="small-9 columns">
                    {{ Form::password('oldPassword', array('placeholder' => 'Current Password')) }}
                    {{ ($errors->has('oldPassword') ?  $errors->first('oldPassword', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

             <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">New</label>
                </div>
                <div class="small-9 columns">
                    {{ Form::password('newPassword', array('placeholder' => 'New Password')) }}
                    {{ ($errors->has('newPassword') ?  $errors->first('newPassword', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

             <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Confirm</label>
                </div>
                <div class="small-9 columns">
                    {{ Form::password('newPassword_confirmation', array('placeholder' => 'Confirm Password')) }}
                    {{ ($errors->has('newPassword_confirmation') ?  $errors->first('newPassword_confirmation', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-9 small-offset-3 columns">
                   {{ Form::submit('Change Password', array('class' => 'button')) }}
                </div>
            </div>

        </div>
    </div>
{{ Form::close() }}

@stop