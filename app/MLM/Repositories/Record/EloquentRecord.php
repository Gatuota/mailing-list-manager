<?php namespace MLM\Repositories\Record;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\Store;
use MLM\Record;

class EloquentRecord implements RecordInterface {
	
	protected $record;
	protected $session;
	private $message;
	private $perPage = 10;

	/**
	 * Construct a new SentryClient Object
	 */
	public function __construct( Model $record, Store $session )
	{
		$this->record = $record;
		$this->session = $session;
	}

	/**
	 * Store a newly created record.
	 *
	 * @return Boolean 
	 */
	public function store( $event, $details )
	{
		$record = new Record(array(
			'event' => $event,
			'details' => json_encode($details),
			'user_id' => $this->session->get('userId')
		));

		// attempt validation
		if ($record->save())
		{
		    // success code
		    return $record;
		}
		else
		{
		    $this->message = 'There was a problem creating the record.';
            $this->errors = $record->errors();

            return false;
		}

	}

	/**
	 * Remove the specified record.
	 *
	 * @param  int  $id
	 * @return Boolean
	 */
	public function destroy( $record_id )
	{
		// Fetch Record from DB
		$record = $this->byId($record_id);

		// Destroy the record 
		$record->delete();

		return true;
	}

	/**
	 * Return a specific record by a given id
	 * 
	 * @param  integer $id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function byId( $record_id )
	{
		return $this->record->find( $record_id );
	}

	/**
	 * Return all the records associated with a given user
	 *
	 * @param  integer $user_id
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function all()
	{
		return $this->record->currentUser()->orderBy('created_at', 'desc')->paginate( $this->perPage );
	}


}

