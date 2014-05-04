<?php namespace MLM;

class Distribution extends BaseModel {


	/**
	 * Mass assigment can be used for these table columns
	 * 
	 * @var array
	 */
	protected $fillable = array('name', 'replyTo', 'subject', 'body', 'active', 'user_id');

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
        return $this->belongsTo('User');
    }

    /**
     * Define the Contact/Distribution Relationship (Many to Many)
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contacts()
    {
        return $this->belongsToMany('MLM\Contact');
    }

	/**
	 * Validation Rules
	 * 
	 * @var array
	 */
	protected $rules = array(
        'name'  	=> 'required',
        'replyTo'  	=> 'required|email',
        'user_id'  	=> 'required',
    );


}
