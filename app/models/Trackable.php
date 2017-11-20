<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Cookie\CookieJar;

class Trackable extends Eloquent implements UserInterface, RemindableInterface {
	
	use UserTrait, RemindableTrait,SortableTrait ;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'trackables';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
  	
	protected $fillable = array('author_id', 'is_mandatory', 'name', 'image', 'unit', 'alert', 'alert_frequence', 'logic_if_greaterthen', 'cancer_killer_x', 'happy_heart_x', 'weight_control_x','mood_meter_x','status');
	
	protected $defaultTimezone = null;
	
	
	
	public static function validate($type = null, $input, $id = null) {
		if($type == 'admin_edit'){
			$rules = array(
			    'name'         => 'required',
				'alert'         => 'required',
				'unit'         => 'required',
				'logic_if_greaterthen'   =>'required',
				'cancer_killer_x'   =>'required',
				'happy_heart_x'   =>'required',
				'weight_control_x'   =>'required',
				'mood_meter_x'   =>'required',
				'alert_frequence'   =>'required',
				//'alert_frequence' => ['required', 'regex:^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$^'],
			);
	 	}elseif($type == 'admin_add'){
			$rules = array(
			    'name'         => 'required',
				'alert'         => 'required',
				'unit'         => 'required',
				'logic_if_greaterthen'   =>'required',
				'cancer_killer_x'   =>'required',
				'happy_heart_x'   =>'required',
				'weight_control_x'   =>'required',
				'mood_meter_x'   =>'required',
				'alert_frequence'   =>'required',
				//'alert_frequence' => ['required', 'regex:^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$^'],
			);
		} 
		
		$messages = array(
			'name.required' 	  	 => 'Name is required.',
			'alert.required' 	  	 => 'Alert message is required.',
			'unit.required' 	  	 => 'Unit is required.',
			'logic_if_greaterthen.required'   => 'Logic value is required',
			'logic_if_greaterthen.numeric'   => 'only numeric value is required',
			'cancer_killer_x.numeric'   => 'only numeric value is required',
			'happy_heart_x.numeric'   => 'only numeric value is required',
			'weight_control_x.numeric'   => 'only numeric value is required',
			'mood_meter_x.numeric'   => 'only numeric value is required',	
			'alert_frequence.required'   => 'only time value is required',
		);

        return Validator::make($input, $rules, $messages);
	}
	
	
	
	
 
}
