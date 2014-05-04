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

		// If neccessary, make sure the current user owns 
		// the specified contact before proceeding
		$this->beforeFilter('my:contact', 
			array('only' => array('show', 'edit', 'update', 'destroy'))
		);

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Pull all the contacts for this user.
		$contacts = $this->contact->all();

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
		// Attempt to save the new contact
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
		// Show the "View Contact Details" page
		$contact = $this->contact->byId($id);

		return View::make('contacts.show')->with('contact', $contact);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Show the "Edit Contact" form
		$contact = $this->contact->byId($id);

		return View::make('contacts.edit')->with('contact', $contact);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Attempt to update the contact
		if ($this->contact->update(Input::all() + array('id' => $id)))
		{
		    // success 
		    Session::flash('success', $this->contact->getMessage());
			return Redirect::to(Input::get('redirect'));
		}
		else
		{
		    // there was a problem
		    Session::flash('error', $this->contact->getMessage());
            return Redirect::url('ContactController@edit', $id)
                ->withInput()
                ->withErrors( $this->contact->getErrors() );
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->contact->destroy($id))
		{
			Session::flash('success', 'Contact Deleted');
            return Redirect::action('ContactController@index');
        }
        else 
        {
        	Session::flash('error', 'Unable to delete Contact');
            return Redirect::action('ContactController@index');
        }
	}


	public function ajaxSearch()
	{
		// Retrieve user's input ('q' query parameter)
		$query = Input::get('q','');

		// If the input is empty, return empty JSON response
		if (trim(urldecode($query)) == '') return Response::json(['data' => ['']], 200);


		$data = array();
		$email_address = array();
		foreach ($this->contact->search($query) as $contact)
		{
			$email_address['firstName'] = $contact->firstName;
			$email_address['lastName'] = $contact->lastName;
			$email_address['displayName'] = $contact->firstName . " " . $contact->lastName;
			$email_address['id'] = $contact->id;
			$email_address['email'] = $contact->email; 

			$data[] = $email_address;
		}

		return Response::json($data);
	}


}
