<?php namespace MLM\Repositories\Contact;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\Store;
use MLM\Contact;

class EloquentContact implements ContactInterface {
	
	protected $contact;
	protected $session;
	private $message;
	private $perPage = 10;

	/**
	 * Construct a new SentryClient Object
	 */
	public function __construct( Model $contact, Store $session )
	{
		$this->contact = $contact;
		$this->session = $session;
	}

	/**
	 * Store a newly created contact.
	 *
	 * @return Boolean 
	 */
	public function store( $data )
	{
		$contact = new Contact( $data + array('user_id' => $this->session->get( 'userId' )));

		// attempt validation
		if ($contact->save())
		{
		    // success code
		    return $contact;
		}
		else
		{
		    $this->message = 'There was a problem creating the contact.';
            $this->errors = $contact->errors();

            return false;
		}

	}
	
	/**
	 * Update the specified contact.
	 *
	 * @param  int  $id
	 * @return Boolean
	 */
	public function update( $data )
	{
		$data['user_id'] = $this->session->get( 'userId' );

		$contact = $this->contact->find( $data['id'] );

		// attempt validation
		if ($contact->update( $data ))
		{
		    // success code
		    return $contact;
		}
		else
		{
		    $this->message = 'There was a problem updating this contact.';
            $this->errors = $contact->errors();

            return false;
		}
	}

	/**
	 * Remove the specified contact.
	 *
	 * @param  int  $id
	 * @return Boolean
	 */
	public function destroy( $contact_id )
	{
		// Fetch Contact from DB
		$contact = $this->byId($contact_id);

		// Destroy the contact 
		$contact->delete();

		return true;
	}

	/**
	 * Return a specific contact by a given id
	 * 
	 * @param  integer $id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function byId( $contact_id )
	{
		return $this->contact->find( $contact_id );
	}

	/**
	 * Return a specific contact by a given email
	 * 
	 * @param  string $email
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function byEmail( $email )
	{
		return $this->contact->currentUser()->where('email', $email)->first();
	}

	/**
	 * Return all the contacts associated with a given user
	 *
	 * @param  integer $user_id
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function all()
	{
		return $this->contact->currentUser()->orderBy('lastName', 'asc')->orderBy('email', 'asc')->paginate( $this->perPage );
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
	 * Check to see if this contact belongs to the current user.
	 * @param  integer $user_id 
	 * @return boolean 
	 */
	public function mine( $contact_id )
	{
		return ( $this->byId( $contact_id )->user_id == $this->session->get( 'userId' ) );
	}

	public function search($query)
	{		
		return $this->contact
			->currentUser()
			->where('firstName','like','%'.$query.'%')
			->orWhere('middleName', 'like','%'.$query.'%')
			->orWhere('lastName', 'like','%'.$query.'%')
			->orWhere('email', 'like','%'.$query.'%')
			->orderBy('lastName','asc')
			->orderBy('email','asc')
			->select('id', 'firstName', 'lastName', 'email')
			->take(10)
			->get();
	}

}

