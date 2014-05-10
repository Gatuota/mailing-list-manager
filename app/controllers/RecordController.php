<?php

use MLM\Repositories\Record\RecordInterface;

class RecordController extends \BaseController {

	private $record;

	public function __construct(RecordInterface $record)
	{
		$this->record = $record;

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
		$records = $this->record->all();

		return View::make('records.index')->with('records', $records);
	}


}
