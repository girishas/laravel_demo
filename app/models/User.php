<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Cookie\CookieJar;

class User extends Eloquent implements UserInterface, RemindableInterface {
	
	use UserTrait, RemindableTrait,SortableTrait ;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	
	protected $fillable = array('password', 'role_id', 'email', 'name', 'description', 'mobile', 'photo', 'gender', 'street_1', 'state', 'city', 'zip', 'status');
	
	protected $defaultTimezone = null;
	
	
	
	public static function validate($type = null, $input, $id = null) {
		if($type == 'admin_edit'){
			$rules = array(
			    'name'         => 'required',
				'email'         => 'required|email|unique:users,email,'.$id,
			);
		}elseif($type == 'admin_login'){
			$rules = array(
			   
				'email'         => 'required|email',
				'password'	  	=> 'required',
			);
		}elseif($type == 'admin_add'){
			$rules = array(
			    'name'         => 'required',
				'email'         => 'required|email|unique:users,email,'.$id,
				'password'	  	=> 'required',
			);
		}else{
			$rules = array(
			    'name'         => 'required',
				'email'         => 'required|email|unique:users,email,'.$id,
				'password'	  	=> array('required', 'min:6'),
			);
		}
		
		$messages = array(
			'name.required' 	  	 => 'Name is required.',
			'email.required' 	  	 => 'Email is required.',
			
			'email.email'  		 	 => 'Invalid Email.',
			'email.unique' 		 	 => 'Email is already exist.',
			'password.min' 			 => 'Minimum length of password should be 6 characters.',
			'mobile.regex'        	 => 'Invalid mobile number',
			'street_1.required' 	 => 'Street #1 is required.',
			'city.required' 	 	 => 'City is required.'
		);

        return Validator::make($input, $rules, $messages);
	}
	
	
	
	
	
	public static function change_password($input) {
		
		$rules = array(
			'cur_password'  			=> 'required | passcheck',
			'new_password'	  			=> array('required', 'min:6', 'confirmed'),
			'new_password_confirmation' => 'required',
		);
		
		$messages = array(
			'cur_password.required' 			=> Session::get('PageText.current_password_required'), 
			'cur_password.passcheck'			=> Session::get('PageText.current_password_wrong'),
			'new_password.required'  			=> Session::get('PageText.new_password_required'),
			'new_password.min' 		  			=> Session::get('PageText.new_password_length'),
			'new_password.confirmed' 			=> Session::get('PageText.confirm_password_different'),
			'new_password_confirmation.required'=> Session::get('PageText.confirm_password_required')
		);
		
		Validator::extend('passcheck', function ($attribute, $value, $parameters) {
			return Hash::check($value, Auth::user()->getAuthPassword());
		});
		
        return Validator::make($input, $rules, $messages);
	}
	
	
	public function save_data($data = array(), $id = null){
		
		$user = ($id != "")?User::find($id):new User();
		
		$fields = array('role_id','name','email', 'password', 'description', 'mobile',  'street_1', 'state', 'city', 'zip', 'status');
		
		$keys = array_keys($data);
		$photo = Input::file('photo');
		
		if($id == ""){
			$user['role_id'] = 2; // company
		}
			
		foreach($keys as $val){
			if($val == 'password'){
				$user->password = Hash::make($data['password']);
			}elseif(in_array($val, $fields)){
				$user->$val = $data[$val];
			}
		}
		
		if($photo){
			$oldPhoto = ($id != "")?$user->photo:'';
			
			if($oldPhoto !="" and file_exists('upload/users/profile-photo/large/'.$oldPhoto)){
				unlink('upload/users/profile-photo/large/'.$oldPhoto);
				unlink('upload/users/profile-photo/thumb/'.$oldPhoto);
			}
			$photo_name = $this->saveProfileImage($photo,  'users/profile-photo', Config::get('constants.USER_THUMB_WIDTH'));
			$user->photo = $photo_name;
			
		}
		
		if($user->save()){
			 
		}else{
			$user  = array();
		}
		return $user;
	}   
	
	
	
	public function saveProfileImage($file, $outer_folder = 'users/profile-photo', $newwidth =null){
		
		$large_image_path = 'upload/'.$outer_folder.'/large/';
		$small_image_path = 'upload/'.$outer_folder.'/thumb/';
		$ext = strtolower(File::extension($file->getClientOriginalName()));
		$filename = strtotime(date('Y-m-d H:i:s')).'_'.rand(111111111,999999999).'.'.$ext;
		$upload_success = $file->move($large_image_path, $filename);
		
		// Get new sizes
		list($ori_width, $ori_height) = getimagesize($large_image_path . $filename); 
		//echo $ori_width; die;
		$img_ratio = ($ori_width/$ori_height);
		//$newwidth = Config::get('constants.USER_THUMB_WIDTH');
		$newheight = $newwidth/$img_ratio;

		// Load
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		if($ext == "png"){
			$source = imagecreatefrompng($large_image_path . $filename);
		}elseif($ext == "gif"){
			$source = imagecreatefromgif($large_image_path . $filename);
		}else{
			$source = imagecreatefromjpeg($large_image_path . $filename);
		}
		
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $ori_width, $ori_height);
		
		if($ext == "png"){
			imagepng($thumb, $small_image_path. $filename);
		}elseif($ext == "gif"){
			imagegif($thumb, $small_image_path . $filename);
		}else{
			imagejpeg($thumb,$small_image_path. $filename);
		}
		return $filename;
	}
	
	
}
