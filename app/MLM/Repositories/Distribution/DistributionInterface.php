<?php namespace MLM\Repositories\Distribution;

interface DistributionInterface {

	/**
	 * Store a newly created distribution.
	 *
	 * @return Boolean 
	 */
	public function store($data);
	
	/**
	 * Update the specified distribution.
	 *
	 * @param  int  $id
	 * @return Boolean
	 */
	public function update($id);

	/**
	 * Remove the specified distribution.
	 *
	 * @param  int  $id
	 * @return Boolean
	 */
	public function destroy($id);

	/**
	 * Return a specific distribution by a given id
	 * 
	 * @param  integer $id
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function byId($id);

	/**
	 * Return all the distributions associated with a given user
	 *
	 * @param  integer $user_id
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function all();

}