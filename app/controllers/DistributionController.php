<?php

use MLM\Repositories\Distribution\DistributionInterface;

class DistributionController extends \BaseController {

	private $distribution;

	public function __construct(DistributionInterface $distribution)
	{
		$this->distribution = $distribution;

		//Check CSRF token on POST
		$this->beforeFilter('csrf', array('on' => 'post'));

		// Make sure the user is logged in. 
		$this->beforeFilter('Sentinel\auth');

		// If neccessary, make sure the current user owns 
		// the specified distribution before proceeding
		$this->beforeFilter('my:distribution', 
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
		$distributions = $this->distribution->all();

		return View::make('distributions.index')->with('distributions', $distributions);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Show the 'Create Distribution' form
		return View::make('distributions.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Attempt to save the new distribution list
		if ($this->distribution->store(Input::all()))
		{
		    // success 
		    Session::flash('success', $this->distribution->getMessage());
			return Redirect::action('DistributionController@index');
		}
		else
		{
		    // there was a problem
		    Session::flash('error', $this->distribution->getMessage());
            return Redirect::action('DistributionController@create')
                ->withInput()
                ->withErrors( $this->distribution->getErrors() );
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($distribution_id)
	{
		// Show the Distribution List details
		$distribution = $this->distribution->byId($distribution_id);

		return View::make('distributions.show')->with('distribution', $distribution);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($distribution_id)
	{
		// Show the "Edit Distribution" form
		$distribution = $this->distribution->byId($distribution_id);

		// Prepare the contacts lists, organized by 'method'
		$contacts = array();

		foreach ($distribution->contacts as $contact)
		{
			$displayName = $contact->firstName . ' ' . $contact->middleName . ' ' . $contact->lastName;
			
			// Prepare contact data for selectize.js
			$contacts[$contact->pivot->method][$contact->id] = array(
				'displayName' => $displayName, 
				'id' => $contact->id, 
				'email' => $contact->email
			);
		}

		return View::make('distributions.edit')->with('distribution', $distribution)->with('contacts', $contacts);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($distribution_id)
	{
		// Attempt to update the distribution
		if ($this->distribution->update(Input::all() + array('id' => $distribution_id)))
		{
		    // success 
		    Session::flash('success', $this->distribution->getMessage());
			return Redirect::to(Input::get('redirect', '/distributions'));
		}
		else
		{
		    // there was a problem
		    Session::flash('error', $this->distribution->getMessage());
            return Redirect::url('DistributionController@edit', $id)
                ->withInput()
                ->withErrors( $this->distribution->getErrors() );
		}
	}


	/**
	 * De-activate the distribution via a "soft delete"
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deactivate($id)
	{
		// Attempt to delete this distribution
		if ($this->distribution->deactivate($id))
		{
			Session::flash('success', 'List Deactivated');
            return Redirect::action('DistributionController@index');
        }
        else 
        {
        	Session::flash('error', 'Unable to deactivate List');
            return Redirect::action('DistributionController@index');
        }
	}

	/**
	 * Re-activate the distribution by restoring from a "soft delete"
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function activate($id)
	{
		// Attempt to delete this distribution
		if ($this->distribution->activate($id))
		{
			Session::flash('success', 'List Activated');
            return Redirect::action('DistributionController@index');
        }
        else 
        {
        	Session::flash('error', 'Unable to activate List');
            return Redirect::action('DistributionController@index');
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
		// Attempt to delete this distribution
		if ($this->distribution->destroy($id))
		{
			Session::flash('success', 'List Deleted');
            return Redirect::action('DistributionController@index');
        }
        else 
        {
        	Session::flash('error', 'Unable to delete List');
            return Redirect::action('DistributionController@index');
        }
	}

}
