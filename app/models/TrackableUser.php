<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Cookie\CookieJar;

class TrackableUser extends Eloquent{
	
	use SortableTrait ;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'trackable_users';
	
	
		
	public function setUpdatedAt($value)
	{
		//Do-nothing
	}
	
	public function getUpdatedAtColumn()
	{
		//Do-nothing
	}
		
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
  	
	protected $fillable = array('user_id', 'trackable_id');
	
}
