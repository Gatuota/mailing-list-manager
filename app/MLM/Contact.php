<?php namespace MLM;

class Contact extends BaseModel {

	/**
	 * Mass assigment can be used for these table columns
	 * 
	 * @var array
	 */
	protected $fillable = array('firstName', 'middleName', 'lastName', 'email', 'phone', 'notes', 'user_id');

	/**
	 * Mass Assigment is not permitted for these table columns
	 * 
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 * Define the Contact/User Relationship (One to Many)
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
    {
        return $this->belongsTo('MLM\User');
    }

    /**
     * Define the Contact/Distribution Relationship (Many to Many)
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function distribution()
    {
        return $this->belongsToMany('Distribution');
    }

	/**
	 * Validation Rules
	 * 
	 * @var array
	 */
	protected $rules = array(
        'email'  	=> 'required|email'
    );

}
