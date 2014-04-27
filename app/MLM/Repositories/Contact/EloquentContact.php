<?php namespace MLM\Repositories\Contact;

use Illuminate\Database\Eloquent\Model;

class EloquentContact implements ContactInterface {
	
	protected $contact;

	/**
	 * Construct a new SentryClient Object
	 */
	public function __construct(Model $contact)
	{
		$this->contact = $contact;
	}

	/**
	 * Store a newly created contact.
	 *
	 * @return Boolean 
	 */
	public function store($data)
	{

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
		
	}


}
