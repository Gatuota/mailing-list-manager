@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
New Broadcast
@stop

{{-- Content --}}
@section('content')
<div class="container">
	{{ Form::open(array('action' => 'BroadcastController@send', 'files' => true, 'id' => 'sendBroadcastForm') ) }}
	  <div class="row">
			<div class="small-12 large-centered columns">
				<div class="row">
					<h3>Send to {{{ $distribution->name }}}</h3>
				</div>

				<div class="row">
					<div class="small-1 columns">
						<label for="right-label" class="right inline">Subject</label>
					</div>                
					<div class="small-11 columns {{ ($errors->has('distribution')) ? 'error' : '' }}">
						{{ Form::text('subject', $distribution->subject, array('placeholder', 'Subject')) }}
						{{ ($errors->has('subject') ? $errors->first('subject', '<small class="error">:message</small>') : '') }}
					</div>
				</div>

				<div class="row">
					<div class="small-1 columns">
						<label for="right-label" class="right inline">Body</label>
					</div>
					<div class="small-11 columns">   
						<div id="body" class="editable editor">
							{{ $distribution->body }}
						</div>
					</div>
				</div>

				<div class="row">
					<div class="small-1 columns">
						<label for="right-label" class="right inline">Attach</label>
					</div>
					<div class="small-11 columns">
						<div class="dropzone" id="dropzone">
							<div class="dz-message">Drop files here (or click to select)</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="small-11 small-offset-1 columns">
						{{ Form::hidden('distribution', $distribution->id) }}
						{{ Form::submit('Send', array('class' => 'button', 'id' => 'submitButton' )) }}
					</div>
				</div>
						   
			</div>
		</div>            
	{{ Form::close() }}
	<div id="spinarea"></div>
</div>


@stop

@section('scripts')
	<script src="{{ asset('js/vendor/medium-editor.min.js') }}"></script>
	<script src="{{ asset('js/vendor/dropzone.min.js') }}"></script>
	<script src="{{ asset('js/vendor/spin.min.js') }}"></script>

	<script>
		var editor = new MediumEditor('#body');

		// Add the WYSIWYG content to the form on submit
		$("#sendBroadcastForm").submit( function(eventObj) {
			$('<input />').attr('type', 'hidden')
				.attr('name', "body")
				.attr('value', $('#body').html())
				.appendTo('#sendBroadcastForm');
		  return true;
		});

		// Dropzone
		Dropzone.options.dropzone = {
			url: "/ajax/broadcast/upload",
			paramName: "file", // The name that will be used to transfer the file
			maxFilesize: 5, // MB
			acceptedFiles: "application/pdf, text/plain, application/msword, application/excel, image/jpeg, image/png, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
			addRemoveLinks: true,
			previewTemplate: "<div class=\"dz-preview dz-file-preview\">" 
				+ "<div class=\"dz-details\">"
				// + "<div class=\"dz-filename\"><span data-dz-name></span></div>"
				+ "<div class=\"dz-size\" data-dz-name></div>"
				+ "<img data-dz-thumbnail />"
				+ "</div>"
				+ "<div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>"
				+ "<div class=\"dz-success-mark\"><span>✔</span></div>"
				+ "<div class=\"dz-error-mark\"><span>✘</span></div>"
				+ "<div class=\"dz-error-message\"><span data-dz-errormessage></span></div>"
				+ "</div>",
			sending: function(file, xhr, formData) {
				// Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.
				// via http://laravel.io/forum/04-17-2014-tokenmismatchexception-with-dropzonejs
				formData.append("_token", $('input[name=_token]').val()); 
			},
			init: function() {
				this.on("success", function(file, response) {
					// Successfull upload - create a hidden input containging the file name. 
					$('<input>').attr({
						type: 'hidden',
						name: 'attachments[]',
						value: response['filename']
					}).appendTo('form');
				}),
				this.on("addedfile", function(file) {
					if (!file.type.match(/image.*/)) {
						// This is not an image, so Dropzone doesn't create a thumbnail.
						// Set a default thumbnail:
						this.emit("thumbnail", file, "{{ asset('img/paperclip.png') }}");
					}
				}),
				this.on("removedfile", function(file) {
					// The user has removed a file. Find the relevan hidden input and remove it.
					$('input[value="' + file.name + '"]').remove();
					// Create a new hidden input to mark this file for deletion.
					$('<input>').attr({
						type: 'hidden',
						name: 'removed[]',
						value: file.name
					}).appendTo('form');

				})
			}
		};

		// Form Submission
		// this is the id of the form
		$("#sendBroadcastForm").on('submit', function(e) {
			e.preventDefault();
			var form = $('#sendBroadcastForm');
			
			var opts = {
				lines: 13, // The number of lines to draw
				length: 20, // The length of each line
				width: 10, // The line thickness
				radius: 30, // The radius of the inner circle
				corners: 1, // Corner roundness (0..1)
				rotate: 0, // The rotation offset
				direction: 1, // 1: clockwise, -1: counterclockwise
				color: '#000', // #rgb or #rrggbb or array of colors
				speed: 1, // Rounds per second
				trail: 60, // Afterglow percentage
				shadow: false, // Whether to render a shadow
				hwaccel: false, // Whether to use hardware acceleration
				className: 'spinner', // The CSS class to assign to the spinner
				zIndex: 2e9, // The z-index (defaults to 2000000000)
				top: '50%', // Top position relative to parent
				left: '50%' // Left position relative to parent
			};
			var spinTarget = document.getElementById('spinarea');
			var spinner = new Spinner(opts).spin(spinTarget);

			form.hide();

			var url = "/ajax/broadcast/send"; // the script where you handle the form input.

			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				success: function(data)
				{
					location.href = "/broadcast/success?name=" + encodeURIComponent('{{ $distribution->name }}');
				},
				error: function(data)
				{
					location.href = "/broadcast/error?name=" + encodeURIComponent('{{ $distribution->name }}');
				}
			});

		});
	  
	</script>
		

@stop

@section('styles')
	<link rel="stylesheet" href="{{ asset('css/medium/medium-editor.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/dropzone/dropzone.css') }}">
	<link rel="stylesheet" href="{{ asset('css/dropzone/basic.css') }}">
@stop