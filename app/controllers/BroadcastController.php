<?php

use MLM\Repositories\Distribution\DistributionInterface;
use Mews\Purifier\Facades\Purifier;
use Carbon\Carbon;

class BroadcastController extends \BaseController {

	private $distribution;

	public function __construct(DistributionInterface $distribution)
	{
		$this->distribution = $distribution;

		//Check CSRF token on POST
		$this->beforeFilter('csrf', array('on' => 'post'));

		// Make sure the user is logged in. 
		$this->beforeFilter('Sentinel\auth');

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Gather this users' active distribution lists
		$distributions = array('' => 'Choose distribution list...') + $this->distribution->active();

		// Show the 'New Broadcast' form
		return View::make('broadcasts.create')->with('distributions', $distributions);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		// Find the selected distribution
		$distribution = $this->distribution->byId(Input::get('distribution'));

		// Need to make sure this list is owned by the current user. 
		if ($distribution->user_id != Session::get('userId'))
		{
			Session::flash('error', 'You do not have access to that distribution list.');
			return Redirect::action('BroadcastController@create');
		}

		// Prepare Date strings
		if (date("H") < 6) {
			// It is currently between midnight and 6am, 
			$today = Carbon::now()->subDay();
			$tomorrow  = Carbon::now();
		} else {
			// It is currently after 6am
			$today = Carbon::now();
			$tomorrow  = Carbon::now()->addDay();
		}

		// Scan for Shortcodes & update
		$distribution->subject = str_replace('[TODAY]', $today->format('n/d/y'), $distribution->subject);
		$distribution->subject = str_replace('[TOMORROW]', $tomorrow->format('n/d/y'), $distribution->subject);
		$distribution->body = str_replace('[TODAY]', $today->format('l F j, Y'), $distribution->body);
		$distribution->body = str_replace('[TOMORROW]', $tomorrow->format('l F j, Y'), $distribution->body);

		// Convert newlines to <br /> in body
		$distribution->body = nl2br($distribution->body);

		// Is there a file to pull the content from? 
		if (Input::hasFile('bodyContent'))
		{
			// Check the file type
			$mimeType = $mime = Input::file('bodyContent')->getMimeType();

			if (in_array($mimeType, array('text/html', 'text/plain')))
			{
				// This is a valid file type.  Open the file and retrieve the contents.
				$contents = File::get(Input::file('bodyContent')->getRealPath());
				
				// Run the contents through HTML Purifier
				$cleanContents = Purifier::clean($contents);

				// Append the cleaned contents to the body of the message. 
				$distribution->body .= '<br /><br />' . $contents;
				
				// Delete the uploaded file - we don't need it any more. 
				File::delete(Input::file('bodyContent')->getRealPath());
			}
		}

		return View::make('broadcasts.show')->with('distribution', $distribution);

	}

	/**
	 * Process the 'send broadcast' form submission
	 * @return [type] [description]
	 */
	public function send()
	{
		// Prepare to send the e-mail. 
		$distribution = $this->distribution->byId(Input::get('distribution'));

		dd($distribution->to());
		
		// Run the body content through HTML Purifier
		$data['body'] = Purifier::clean(Input::get('body'));
 
 		// Prepare the message & submit
		Mail::queue('emails.broadcast', $data, function($message) use ($distribution)
		{
			$message->sender($distribution->replyTo);
			$message->replyTo($distribution->replyTo);
			$message->subject(e(Input::get('subject')));
			$recipients = $distribution->contacts;

			// Add recipients
			foreach ($recipients as $contact)
			{
				switch ($contact->pivot->method) {
					case 'cc':
						$message->cc($contact->email);
						break;

					case 'bcc':
						$message->bcc($contact->email);
						break;
					
					default:
						$message->to($contact->email);
						break;
				}
			}
			
			// Add attachments, if necessary
			$path = 'uploads/' . Session::get('email');

			if (Input::has('attachments') && file_exists($path))
			{
				$attachments = Input::get('attachments');
				foreach ($attachments as $filename) {
					$message->attach($path . '/' . $filename);
				}
			}

		});

		// Remove attachments from storage
		$path = 'uploads/' . Session::get('email');
		if (Input::has('attachments') && file_exists($path))
		{
			$attachments = Input::get('attachments');
			foreach ($attachments as $filename) {
				unlink($path . '/' . $filename);
			}
		}

		// Remove any 'removed' files from storage
		if (Input::has('removed') && file_exists($path))
		{
			$removed = Input::get('removed');
			foreach ($removed as $filename) {
				unlink($path . '/' . $filename);
			}
		}

		Session::flash('success', 'Broadcast sent to ' . $distribution->name);
		return Redirect::action('BroadcastController@create');
	}

	/**
	 * Handle an ajax upload from dropzone.js
	 * @return json 
	 */
	public function upload()
	{
		$file = Input::file('file');
		$destinationPath = 'uploads/' . Session::get('email');
 
		if (! file_exists($destinationPath))
		{
			mkdir($destinationPath, 0775);
		}

		$filename = $file->getClientOriginalName();
		$upload_success = Input::file('file')->move($destinationPath, $filename);
		 
		if( $upload_success ) {
			return Response::json(array(
				'status' => 'success',
				'filename' => $filename
			), 200);
		} else {
		   return Response::json(array(
				'status' => 'error'
		   ), 400);
		}
	}
}
