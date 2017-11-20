<?php
class ARStatistic extends Eloquent {
	
	use SortableTrait ;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ar_statistics';

	
	protected $fillable = array('company_id', 'date_on', 'paid', 'assistance', 'processing');
	
	public function setUpdatedAt($value)
	{
		//Do-nothing
	}
	
	public function getUpdatedAtColumn()
	{
		//Do-nothing
	}
	
}
