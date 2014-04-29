<?php namespace MLM\Repositories\Distribution;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\Store;
use MLM\Distribution;

class EloquentDistribution implements DistributionInterface {
	
	protected $distribution;
	protected $session;
	private $message;
	private $perPage = 10;

	/**
	 * Construct a new SentryClient Object
	 */
	public function __construct( Model $distribution, Store $session )
	{
		$this->distribution = $distribution;
		$this->session = $session;
	}

	/**
	 * Store a newly created distribution.
	 *
	 * @return Boolean 
	 */
	public function store( $data )
	{
		$distribution = new Distribution( $data + array('user_id' => $this->session->get( 'userId' ), 'active' => 1));

		//dd($data + array('user_id' => $this->session->get( 'userId' )));

		// attempt validation
		if ($distribution->save())
		{
		    // success code
		    return $distribution;
		}
		else
		{
		    $this->message = 'There was a problem creating the distribution.';
            $this->errors = $distribution->errors();

            return false;
		}

	}
	
	/**
	 * Update the specified distribution.
	 *
	 * @param  int  $id
	 * @return Boolean
	 */
	public function update( $data )
	{
		$data['user_id'] = $this->session->get( 'userId' );

		$distribution = $this->distribution->find( $data['id'] );

		// attempt validation
		if ($distribution->update( $data ))
		{
		    // success code
		    return $distribution;
		}
		else
		{
		    $this->message = 'There was a problem updating this distribution.';
            $this->errors = $distribution->errors();

            return false;
		}
	}

	/**
	 * Remove the specified distribution.
	 *
	 * @param  int  $id
	 * @return Boolean
	 */
	public function destroy( $distribution_id )
	{
		// Fetch Distribution from DB
		$distribution = $this->byId($distribution_id);

		// Destroy the distribution 
		$distribution->delete();

		return true;
	}

	/**
	 * Return a specific distribution by a given id
	 * 
	 * @param  integer $id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function byId( $distribution_id )
	{
		return $this->distribution->find( $distribution_id );
	}

	/**
	 * Return all the distributions associated with a given user
	 *
	 * @param  integer $user_id
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function all( )
	{
		return $this->distribution->currentUser()->orderBy('created_at', 'asc')->paginate( $this->perPage );
	}

	/**
	 * Return the Validator response message bag
	 * @return Illuminate\Support\MessageBag
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * Return the Validator errors
	 * @return [type] [description]
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * Check to see if this distribution belongs to the current user.
	 * @param  integer $user_id 
	 * @return boolean 
	 */
	public function mine( $distribution_id )
	{
		return ( $this->byId( $distribution_id )->user_id == $this->session->get( 'userId' ) );
	}

}

