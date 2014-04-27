<?php

use MLM\Repositories\Contact\ContactInterface;

class ContactController extends \BaseController {

	private $contact;

	public function __construct(ContactInterface $contact)
	{
		$this->contact = $contact;

		//Check CSRF token on POST
		$this->beforeFilter('csrf', array('on' => 'post'));

		// Make sure the user is logged in. 
		$this->beforeFilter('Sentinel\auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Pull all the contacts for this user.
		$contacts = $this->contact->byUser(Session::get('userId'));

		// Show the Contacts Index View
		return View::make('contacts.index')->with('contacts', $contacts);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Show the Create Contact Form
		return View::make('contacts.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// attempt validation
		if ($this->contact->store(Input::all()))
		{
		    // success 
		    Session::flash('success', $this->contact->getMessage());
			return Redirect::action('ContactController@index');
		}
		else
		{
		    // there was a problem
		    Session::flash('error', $this->contact->getMessage());
            return Redirect::action('ContactController@create')
                ->withInput()
                ->withErrors( $this->contact->getErrors() );
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
