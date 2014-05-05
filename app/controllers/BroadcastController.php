<?php

use MLM\Repositories\Distribution\DistributionInterface;

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


}
