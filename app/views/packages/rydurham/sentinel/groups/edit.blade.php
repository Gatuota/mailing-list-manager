@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Edit Group
@stop

{{-- Content --}}
@section('content')
{{ Form::open(array('action' =>  array('Sentinel\GroupController@update', $group->id), 'method' => 'put')) }}
    <div class="row">
        <div class="small-6 large-centered columns">
            <h3>Edit Group</h3>

            <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">Name</label>
                </div>
                <div class="small-10 columns {{ ($errors->has('name')) ? 'error' : '' }}">
                    {{ Form::text('name', $group->name, array('placeholder' => 'Name', 'autofocus')) }}
                    {{ ($errors->has('name') ? $errors->first('name', '<small class="error">:message</small>') : '') }}
                </div>
            </div>
    
            <div class="row">
                {{ Form::label('edit_memberships', 'Permissions') }}  
                <?php 
                    $permissions = $group->getPermissions(); 
                    if (!array_key_exists('admin', $permissions)) $permissions['admin'] = 0;
                    if (!array_key_exists('users', $permissions)) $permissions['users'] = 0;
                ?> 
                <div class="small-10 small-offset-2 columns">
                    {{ Form::checkbox('adminPermissions', 1, $permissions['admin'] ) }} Admin
                </div>

                <div class="small-10 small-offset-2 columns">
                    {{ Form::checkbox('userPermissions', 1, $permissions['users'] ) }} Users
                </div>
            </div>

            <div class="row">
                <div class="small-10 small-offset-2 columns">
                    {{ Form::hidden('id', $group->id) }}
                    {{ Form::submit('Save Changes', array('class' => 'button')) }}
                </div>
            </div>

        </div>
    </div>
{{ Form::close() }}
@stop