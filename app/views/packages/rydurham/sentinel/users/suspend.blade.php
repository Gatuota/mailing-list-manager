@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Suspend User
@stop

{{-- Content --}}
@section('content')
{{ Form::open(array('action' => array('Sentinel\UserController@suspend', $id), 'method' => 'post')) }}
    <div class="row">
        <div class="small-6 large-centered columns">
            <h3>Suspend User</h3>

            <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">Time</label>
                </div>
                <div class="small-10 columns {{ ($errors->has('minutes')) ? 'error' : '' }}">
                    {{ Form::text('minutes', null, array('placeholder' => 'Minutes', 'autofocus')) }}
                    {{ ($errors->has('minutes') ? $errors->first('minutes', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

	        <div class="row">
                <div class="small-10 small-offset-2 columns">
                    {{ Form::hidden('id', $id) }}
                    {{ Form::submit('Suspend', array('class' => 'button')) }}
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}

@stop