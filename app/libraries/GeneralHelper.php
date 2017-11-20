<?php

class GeneralHelper {
	public static function showUserImg($file=null, $class='', $width='', $height='', $title='', $type='thumb', $maxHeight=""){
		$title  = strtolower($title);
		if($type==''){
			$type = 'thumb';
		}
		$path	= 'upload/users/profile-photo/'.$type.'/'. $file;
		$style = '';
		if($width!=''){
			$style = 'width:'. $width .';';
		}
		
		if($height!=''){
			$style .= 'height:'. $height .';';
		}
		
		if($maxHeight!=''){
			$style .= 'max-height:'. $maxHeight .';';
		}
		
		if($file != '' and file_exists($path)){ 
			return HTML::image($path, '', array('title'=>$title, 'alt'=>$title, 'class'=>$class, 'style'=>$style)); 
		}else{
			return HTML::image('img/no_profile.png', '', array('title'=>$title, 'alt'=>$title, 'class'=>$class, 'style'=>$style)); 
		}
	}
	
	
	public static function showTrackableImg($file=null, $class='', $width='', $height='', $title='', $type='thumb', $maxheight="")
	{
		$title  = strtolower($title);
		if($type=='')
		{
			$type = 'thumb';
		}		
		$path = 'upload/trackable/'.$type.'/'. $file;				
		$style = '';				
		if($width!='')
		{
			$style = 'width:'. $width .';';
		}
		
		if($height!='')
		{
			$style .= 'height:'. $height .';';
		}
		
		if($maxheight!='')
		{
			$style .= 'max-height:'. $maxheight .';';
		}
		
		if($file !='' and file_exists($path))
		{
			return HTML::image($path, '', array('title'=>$title, 'alt'=>$title, 'class'=>$class, 'style'=>$style));
		}
		else
		{
			return HTML::image('img/no_profile.png', '', array('title'=>$title, 'alt'=>$title, 'style'=>$style, 'class'=>$class));
		}
	}
	
	
	public static function getAllBarChartData($type = null, $company_id ="All", $role_id =1, $type_dsh = ""){
		$last_day  = date('Y-m-t', strtotime("-2 months"));
		
		$count = DB::table('patients')->where('status','like',trim($type).'%')->where('patients.is_deleted', 0);
		if($type_dsh == 1){
			$count = $count->whereDate('date_from', '>=', date('Y-m-1', strtotime('-1 months')))->whereDate('date_from', '<=', date('Y-m-t', strtotime('-1 months')));
		}elseif($type_dsh == 2){
			$count = $count->whereDate('date_from', '<=', $last_day);
		}else{
			$count = $count->whereDate('date_from', '<=', $last_day);
		}
		
		if($role_id == 2){
			$count = $count->where('company_id', $company_id );
		}
		$count = $count->count();
		return $count;
	}
	
	public static function getARdataCount($is_deleted = 0, $user_id = null){
		$count = DB::table('patients')->where('patients.is_deleted', $is_deleted);
		if(Auth::User()->role_id == 2){
			$count = $count->where('company_id', Auth::id());
		}
		if($user_id){
			$count = $count->where('company_id',  $user_id);
		}
		$count = $count->count();
		return $count;
	}
	
	
	public static function getARdataCountToday($status){
		$count = DB::table('patients')->where('patients.is_deleted', 0)->where('patients.status', 'like', $status."%")->whereDate('date_from', '=', date('Y-m-d'));
		if(Auth::User()->role_id == 2){
			$count = $count->where('company_id', Auth::id());
		}
		
		$count = $count->count();
		return $count;
	}
	
	
	
	
	public static function getClientdataCount($is_deleted = 0){
		$count = DB::table('users')->where('role_id', 2)->where('users.is_deleted', $is_deleted)->count();
		return $count;
	}
	
	
	public static function getTrackabledataCount(){
		$count = DB::table('trackables')->count();
		return $count;
	}
	
	public static function getAllActiveCompanies(){
		$data = DB::table('users')->where('role_id', 2)->where('users.is_deleted', 0)->where('users.status', 1)->lists('name', 'id');
		return $data;
	}
	
	
	public static function getCompanyNameByID($id = null){
		$data = DB::table('users')->where('id', $id)->first(array('name', 'id'));
		$name = $data?$data->name:"";
		return $name;
	}
	
	
	
	public static function getNotesNotifications(){
		$data  = DB::table('patients')->where('notes_updated', 1)->get();
		return $data;
	}
	
	
	public static function getTrackbleName($trackable_id = null){
		$trackables  = Trackable::find($trackable_id);
		$name        = $trackables?$trackables->name:'All Trackables';
		return $name;
	}
	
	public static function getAssignedUsers($trackable_id = null){
		$trackables  = DB::table('trackable_users')->where('trackable_id', $trackable_id)->lists('user_id');
		
		return $trackables;
	}
	
}