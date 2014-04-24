@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Resend Activation
@stop

{{-- Content --}}
@section('content')
{{ Form::open(array('action' => 'Sentinel\UserController@resend', 'method' => 'post')) }}
     <div class="row">
        <div class="small-6 large-centered columns">       	
            <h3>Resend Activation Email</h3>
    		
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
                <div class="small-10 small-offset-2 columns">
                    {{ Form::submit('Resend', array('class' => 'button')) }}
                </div>
            </div>

            

        
        </div>
    </div>
{{ Form::close() }}

@stop
