@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Register
@stop

{{-- Content --}}
@section('content')
{{ Form::open(array('action' => 'Sentinel\UserController@store')) }}
  <div class="row">
        <div class="small-6 large-centered columns">
            <h3>Register New Account</h3>

            <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">Email</label>
                </div>
                <div class="small-10 columns {{ ($errors->has('email')) ? 'error' : '' }}">
                    {{ Form::text('email', null, array('placeholder' => 'Email', 'autofocus')) }}
                    {{ ($errors->has('email') ? $errors->first('email', '<small class="error">:message</small>') : '') }}
                </div>
            </div>
            
            <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">Password</label>
                </div>
                <div class="small-10 columns">
                    {{ Form::password('password', array('placeholder' => 'Password')) }}
                    {{ ($errors->has('password') ?  $errors->first('password', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">Confirm</label>
                </div>
                <div class="small-10 columns">
                    {{ Form::password('password_confirmation', array('placeholder' => 'Confirm Password')) }}
                    {{ ($errors->has('password_confirmation') ?  $errors->first('password_confirmation', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

             <div class="row">
                <div class="small-10 small-offset-2 columns">
                    {{ Form::submit('Register', array('class' => 'button' )) }}
                </div>
            </div>
                       
        </div>
    </div>            
{{ Form::close() }}



@stop