<?php namespace MLM;

class Record extends BaseModel {

	/**
	 * Mass assigment can be used for these table columns
	 * 
	 * @var array
	 */
	protected $fillable = array('event', 'details', 'user_id');

	/**
	 * Mass Assigment is not permitted for these table columns
	 * 
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 * Define the Record/User Relationship (One to Many)
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
    {
        return $this->belongsTo('MLM\User');
    }

	/**
	 * Validation Rules
	 * 
	 * @var array
	 */
	protected $rules = array(
        'event'  	=> 'required',
        'user_id'	=> 'required'
    );

}
