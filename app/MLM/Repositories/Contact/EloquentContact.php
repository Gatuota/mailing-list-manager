<?php namespace MLM\Repositories\Contact;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\Store;
use MLM\Contact;

class EloquentContact implements ContactInterface {
	
	protected $contact;
	protected $session;
	private $message;

	/**
	 * Construct a new SentryClient Object
	 */
	public function __construct(Model $contact, Store $session)
	{
		$this->contact = $contact;
		$this->session = $session;
	}

	/**
	 * Store a newly created contact.
	 *
	 * @return Boolean 
	 */
	public function store($data)
	{
		$data['user_id'] = $this->session->get('userId');

		$contact = new Contact($data);

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
	public function update($id)
	{

	}

	/**
	 * Remove the specified contact.
	 *
	 * @param  int  $id
	 * @return Boolean
	 */
	public function destroy($id)
	{

	}

	/**
	 * Return a specific contact by a given id
	 * 
	 * @param  integer $id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function byId($id)
	{

	}

	/**
	 * Return a specific contact by a given email
	 * 
	 * @param  string $email
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function byEmail($email)
	{

	}

	/**
	 * Return all the contacts associated with a given user
	 *
	 * @param  integer $user_id
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function byUser($user_id)
	{
		return $this->contact->currentUser($user_id)->get();
	}


	public function getMessage()
	{
		return $this->message;
	}


	public function getErrors()
	{
		return $this->errors;
	}

}
