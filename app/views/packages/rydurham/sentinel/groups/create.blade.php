@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Create Group
@stop

{{-- Content --}}
@section('content')
{{ Form::open(array('action' => 'Sentinel\GroupController@store')) }}
    <div class="row">
        <div class="small-6 large-centered columns">
            <h3>Create New Group</h3>
    
            <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">Name</label>
                </div>
                <div class="small-10 columns {{ ($errors->has('name')) ? 'error' : '' }}">
                    {{ Form::text('name', null, array('placeholder' => 'Name', 'autofocus')) }}
                    {{ ($errors->has('name') ? $errors->first('name', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                {{ Form::label('edit_memberships', 'Permissions') }}   
                <div class="small-10 small-offset-2 columns">
                    {{ Form::checkbox('adminPermissions', 1) }} Admin
                </div>

                <div class="small-10 small-offset-2 columns">
                    {{ Form::checkbox('userPermissions', 1) }} User
                </div>
            </div>

            <div class="row">
                <div class="small-10 small-offset-2 columns">
                    {{ Form::submit('Create New Group', array('class' => 'button')) }}
                </div>
            </div>
            
        </div>
    </div>
{{ Form::close() }}

@stop