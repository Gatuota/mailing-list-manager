@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
New Broadcast
@stop

{{-- Content --}}
@section('content')
{{ Form::open(array('action' => 'BroadcastController@show', 'files' => true, 'onsubmit' => 'return beforeSubmit();') ) }}
  <div class="row">
        <div class="small-6 large-centered columns">
            <h3>New Broadcast</h3>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">List</label>
                </div>
                <div class="small-9 columns {{ ($errors->has('distribution')) ? 'error' : '' }}">
                    {{ Form::select('distribution', $distributions, array(), array('placeholder' => 'Name', 'autofocus')) }}
                    {{ ($errors->has('distribution') ? $errors->first('distribution', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Content</label>
                </div>
                <div class="small-9 columns">   
                    {{ Form::file('bodyContent', array('id' => 'bodyContent'))}}
                    <small class="error" id="fileError" style="display:none">Only .html, .htm and .txt files are accepted.</small>
                </div>
            </div>

            <div class="row">
                <div class="small-9 small-offset-3 columns">
                    {{ Form::submit('Create', array('class' => 'button', 'id' => 'submitButton' )) }}
                    {{ Form::reset('Reset', array('class' => 'button secondary'))}}
                </div>
            </div>
                       
        </div>
    </div>            
{{ Form::close() }}

@stop

@section('scripts')
    <script src="{{ asset('js/vendor/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery.fileupload.js') }}"></script>
    <script>
        function beforeSubmit()
        {
            var file = document.getElementById("bodyContent");

            var ext = file.value.match(/\.([^\.]+)$/)[1];
            console.log(ext);
            switch(ext)
            {
                case 'html':
                case 'htm':
                case 'txt':
                    console.log('allowed');
                    $('#fileError').hide();
                    $('#submitButton').addClass('disabled');
                    return true;
                    break;
                default:
                    console.log('not allowed');
                    $('#fileError').show();
                    this.value='';
                    return false;
                    break;
            }
        }

    </script>
@stop