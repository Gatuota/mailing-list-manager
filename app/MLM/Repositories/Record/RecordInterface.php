<?php namespace MLM\Repositories\Record;

interface RecordInterface {

	/**
	 * Store a newly created record.
	 *
	 * @return Boolean 
	 */
	public function store($event, $details);

	/**
	 * Remove the specified record.
	 *
	 * @param  int  $id
	 * @return Boolean
	 */
	public function destroy($id);

	/**
	 * Return a specific record by a given id
	 * 
	 * @param  integer $id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function byId($id);

	/**
	 * Return all the records associated with a given user
	 *
	 * @param  integer $user_id
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function all();

}