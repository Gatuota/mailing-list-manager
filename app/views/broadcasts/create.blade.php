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
                    {{ Form::select('distribution', $distributions, array(), array('placeholder' => 'Name', 'autofocus', 'id' => 'distribution', 'style' => 'margin: 0')) }}
                    <small class="error" id="distributionError" style="display:none">You must choose a distribution list.</small>
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
    <script>
        function beforeSubmit()
        {
            var file = document.getElementById("bodyContent");
            var distribution = document.getElementById("distribution")

            // If no distribution has been selected, halt submission and warn the user. 
            if (distribution.value == "")
            {
                $("#distributionError").show();
                return false;
            }

            // If there is no file selected, no need to check the file extension. 
            if (file.value == "")
            {
                return true;
            }

            var ext = file.value.match(/\.([^\.]+)$/)[1];

            switch(ext)
            {
                case 'html':
                case 'htm':
                case 'txt':
                    $('#fileError').hide();
                    $('#submitButton').addClass('disabled');
                    return true;
                    break;
                default:
                    $('#fileError').show();
                    this.value='';
                    return false;
                    break;
            }
        }

    </script>
@stop