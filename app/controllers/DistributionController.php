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
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
