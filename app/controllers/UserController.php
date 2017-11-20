<?php
	class UserController extends BaseController { 
		
		public function __construct(){
			$this->beforeFilter(function(){
				
				if(Auth::guest())
				return Redirect::to('/login');
			},['except' => ['']]);
		}
		
		
		//add company 
		public function admin_add(){
			if(Auth::User()->role_id == 2 ) {
				return Redirect::to('admin/dashboard/');
			}
			
			if(!empty($_POST)){
				$validator = User::validate('admin_add', Input::all());
				
				if ( $validator->fails() ) {
					Session::flash('errormessage', 'User could not be created, Please correct errors');
					return Redirect::to('admin/users/add')->withErrors($validator)->withInput(Input::except('password','photo'));
					} else {
					$user = new User();
					$savedUser = $user->save_data(Input::all());
					if ($savedUser){
						return Redirect::to('admin/users/2')->with('message', 'User has been created successfully.');
					}
					return Redirect::to('admin/users/2');
				}
			}
			return View::make('backend.users.admin_add');
		}
		
		
		
		//company list 
		public function admin_index($role_id = null){
			
			if(Auth::User()->role_id == 2 ) {
				return Redirect::to('admin/dashboard/');
			} 
			
			
			if (Session::has('usearch') and (isset($_GET['page']) and $_GET['page']>=1) OR (isset($_GET['s']) and $_GET['s'])) {
				$_POST = Session::get('usearch');
			}
			
			$users = User::sortable()->where('users.role_id', $role_id)->where('users.is_deleted', 0);
			
			if(! empty($_POST)){
				if(isset($_POST['name']) and $_POST['name'] !=''){
					$name = $_POST['name'];
					Session::put('usearch.name', $name);
					$users = $users->where('users.name', 'like', trim($name)."%");
				}
				if(isset($_POST['email']) and $_POST['email'] !=''){
					$email = $_POST['email'];
					Session::put('usearch.email', $email);
					$users = $users->where('users.email', 'like', trim($email)."%");
				}
			}else{
				Session::forget('usearch');
			}
			
			$users = $users->orderBy('id', 'DESC')->paginate(Config::get('constants.PAGINATION'));
			
			if(isset($_GET['s']) and $_GET['s']){
				$users->appends(array('s' => $_GET['s'],'o'=>$_GET['o']))->links();
			}
			
			return View::make('backend.users.admin_index', compact('users'));
			
		}
		
		
		
		
		public function getDashBoard($trackable_id = null){	
		    $client_id  = Auth::id();
			
			$first_day = strtotime(date('d-m-Y', strtotime("-1 months"))); 
			$last_day  = strtotime(date('d-m-Y'));
			
			$datesArr = array(); $barData = array(); $graphData = array();
			for ($i=$first_day; $i<=$last_day; $i+=86400) {  
				$datesArr[] 									= date("m-d", $i);  
				$graphData['cancerKiller'][date("Y-m-d", $i)] 	= 0;
				$graphData['weightControl'][date("Y-m-d", $i)] 	= 0;
				$graphData['heartHappy'][date("Y-m-d", $i)] 	= 0;
				$graphData['moodMeter'][date("Y-m-d", $i)] 		= 0;
			}
			
			$data = DB::table('trackable_values')->select(DB::raw('sum(cancer_killer_x) as total_cancer_killer, sum(happy_heart_x) as total_happyheart, sum(weight_control_x) as total_weight_control, sum(mood_meter_x) as total_moodmeter'))
					->where('user_id', $client_id)->whereDate('created_at', '>=',date('Y-m-d', strtotime("-1 months")))->whereDate('created_at','<=', date('Y-m-d'));
			
			if($trackable_id){
				$data = $data->where('trackable_id', $trackable_id);
			}
			
			$data = $data->first();
			
			$barData = DB::table('trackable_values')->select('created_at', DB::raw('sum(cancer_killer_x) as total_cancer_killer, sum(happy_heart_x) as total_happyheart, sum(weight_control_x) as total_weight_control, sum(mood_meter_x) as total_moodmeter'))
					->where('user_id', $client_id)->whereDate('created_at', '>=',date('Y-m-d', strtotime("-1 months")))->whereDate('created_at','<=', date('Y-m-d'));
			
			if($trackable_id){
				$barData = $barData->where('trackable_id', $trackable_id);
			}
			
			$barData = $barData->groupBy('created_at')->orderBy('created_at', 'Desc')->get();
			
		
			foreach($barData as $val){
				$valDate   								= date('Y-m-d', strtotime($val->created_at));
				$graphData['cancerKiller'][$valDate] 	= $val->total_cancer_killer;
				$graphData['weightControl'][$valDate] 	= $val->total_weight_control;
				$graphData['heartHappy'][$valDate] 		= $val->total_happyheart;
				$graphData['moodMeter'][$valDate] 		= $val->total_moodmeter;
			}
			
			
			$users  = User::sortable()->where('role_id', 2)->where('users.is_deleted', 0)->paginate(10);
		
			$trackables  = DB::table('trackables')->where('status',1)->get();
			
			$trackable_users  = DB::table('trackable_users')->where('user_id', Auth::id())->lists('trackable_id');
			
			$trackable_alert  = DB::table('trackable_users')->join('trackables', 'trackables.id', '=', 'trackable_users.trackable_id')
								->where('trackable_users.user_id', Auth::id())->select('trackables.*')->where('is_mandatory',1)->where('trackables.alert_frequence', '<=', date('H:i:s'))->get();
								//->whereDate('trackables.created_at', '=', date('Y-m-d'))->whereDate('trackables.alert_frequence', '>=', date('H:i'));
			//echo  "<pre>"; print_r($trackable_alert); die;
			$trackable_values = DB::table('trackable_values')->where('user_id', Auth::id())->whereDate('created_at', '=', date('Y-m-d'))->lists('trackable_id');
			//echo  "<pre>"; print_r($trackable_alert); die;
			Session::put('my_trackable', $trackable_values);
			return View::make('backend.dashboard', compact('graphData', 'datesArr', 'data', 'users', 'trackables', 'trackable_users', 'trackable_alert'));
		}
		
		
		public function trackbles_users_status($id =  null, $dashboard_id = null){
			$trackable_users  = DB::table('trackable_users')->where('trackable_id', $id)->where('user_id', Auth::id())->first();
			
			if($trackable_users){
				$id  = $trackable_users->id;
				$trackableUser  = TrackableUser::find($id);
				if($trackableUser->delete()){
					return Redirect::to('admin/dashboard/'.$dashboard_id)->with('message', 'Trackable has been removed successfully.');
				}
			}else{
				$data    = array('trackable_id' => $id, 'user_id' => Auth::id());
				$trackableUser  = TrackableUser::create($data);
				if($trackableUser){
					return Redirect::to('admin/dashboard/'.$dashboard_id)->with('message', 'Trackable has been assigned successfully.');
				}
			}
			
		}
		
		
		public function trackable_values($dashboard_id = null){
			if(Input::get('value')){
				$id  =  Input::get('trackable_id');
				$value  =  Input::get('value');
				$date_e  =  Input::get('date_e');
				$trackable = DB::table('trackables')->where('id', $id)->first();
				if($value >= $trackable->logic_if_greaterthen){
					$is_exist   = DB::table('trackable_values')->where('user_id', Auth::id())->whereDate('created_at', '=', $date_e)->where('trackable_id', $id)->first();
					if($is_exist){
						$t_valueID						= $is_exist->id;
						$trackableValue  				= TrackableValue::find($t_valueID);
					}else{
						$trackableValue  					= new TrackableValue();
					}
					
					$multiX                             = ($value/$trackable->logic_if_greaterthen);
					$multiX								= number_format($multiX, 2);
					$trackableValue->value				= $value;
					$trackableValue->user_id			= Auth::id();
					$trackableValue->trackable_id		= $id;
					$trackableValue->cancer_killer_x	= $multiX*$trackable->cancer_killer_x;
					$trackableValue->happy_heart_x		= $multiX*$trackable->happy_heart_x;
					$trackableValue->weight_control_x	= $multiX*$trackable->weight_control_x;
					$trackableValue->mood_meter_x		= $multiX*$trackable->mood_meter_x;
					$trackableValue->created_at			= $date_e;
					if($trackableValue->save()){
						$oldSess = Session::get('my_trackable')?Session::get('my_trackable'):array();
						$oldSess[] = $id;
						Session::put('my_trackable', $oldSess);
						return Redirect::to('admin/dashboard/'.$dashboard_id);
					}
				}
			}
			return Redirect::to('admin/dashboard/'.$dashboard_id);
		}
		
		
		//Deleted Company List 
		public function admin_del($role_id = null){
			if(Auth::User()->role_id == 2 ) {
				return Redirect::to('admin/dashboard/');
				} else {
				$users = User::sortable()->where('users.role_id', $role_id);
				$users = $users->where('is_deleted', 1 )->where('role_id', $role_id )->orderBy('id', 'DESC')->paginate(Config::get('constants.PAGINATION'));
				return View::make('backend.users.admin_del',compact('users'));
			}
		}	
		
		//company status
		public function admin_status($id){
			$user = User::find($id);
			$role_id = $user->role_id;
			if($user->status==1){
				$user->status = 0;
				}else {
				$user->status = 1;
			}
			
			if($user->save()){
				Session::flash('message', 'Status has been changed successfully!');
				return Redirect::to('admin/users/'.$role_id);
			}
			
		}
		//company edit
		public function admin_edit($role_id = null, $id = null) { 
			if(Auth::User()->role_id == 2 && User::find($id) ) {
				return Redirect::to('admin/dashboard/');
				} else {
				$data = User::find($id);
				
				if(!empty($_POST)){
					$validator = User::validate('admin_edit', Input::all(), $id);
					
					if ( $validator->fails() ) {
						Session::flash('errormessage', 'User could not be updated, Please correct errors');
						return Redirect::to('admin/users/edit/'.$role_id.'/'.$id)->withErrors($validator)->withInput(Input::except('photo'));
						} else {
						$user = new User();
						$savedUser = $user->save_data(Input::all(), $id);
						
						if ($savedUser){
							if($savedUser->role_id>2) {
								return Redirect::to('admin/users/3')->with('message', 'User has been updated successfully');
								} else {
								return Redirect::to('admin/users/'.$savedUser->role_id)->with('errormessage', 'User has been updated successfully');
							}
						}
						return Redirect::to('admin/users/'.$role_id);
					}
				}
				$users = DB::table('users')->orderBy('id', 'DESC')->get();
				return View::make('backend.users.admin_edit', array('data' =>$data));
			}
		}
		
		
		
		//company single profile view
		public function admin_view( $role_id = null, $id=null){
			if(Auth::User()->role_id ==2 ) {
				return Redirect::to('admin/dashboard/');
				} else {
				$users = DB::table('users')->where('id', $id )->where('role_id', $role_id )->orderBy('id', 'DESC')->first();
				return View::make('backend.users.admin_view', array('user' =>$users));
			}
		} 
		
		
		
		
		//company password change
		public function admin_change_password($role_id = null, $id=null){
			if(Auth::User()->role_id ==2 && Auth::id()!=$id ) {
				return Redirect::to('admin/dashboard/');
				} else {
				if(!empty($_POST)){
					$rules = array(
					'password'	  				=> 'required|min:6|confirmed',
					'password_confirmation'     => 'required',
					);
					$messages = array(
					'password.min' 		  => "Password length should not be less than 6 characters",
					'password.confirmed'  => "Password does not match",
					);
					$validator = Validator::make( Input::all(), $rules, $messages ); 
					
					if ($validator->fails()) {
						Session::flash('errormessage', 'Password could not be changed, Please correct errors');
						return Redirect::to('admin/users/change_password/'.$role_id.'/'.$id)->withErrors($validator);
						} else {
						$user = User::find($id);
						$user->password 	= Hash::make(Input::get('password'));
						if($user->save()){
							return Redirect::to('admin/users/change_password/'.$role_id.'/'.$id)->with('message', 'User password has been changed successfully.');
						}
					}
				}
				
				$data = User::find($id);
				return View::make('backend.users.admin_change_password', compact('data'));
			}
		}
		
		
		
		
		//company remove by status
		public function admin_remove($id){
			$user = User::find($id);
			$role_id = $user->role_id;
			if($user->is_deleted==1){
				$user->is_deleted = 0;
			}else {
				$user->is_deleted = 1;
			}
			
			if($user->save()){
				Session::flash('message', 'User account  has been deleted successfully.');
				return Redirect::to('admin/users/'.$role_id);
			}
			
		}
		
		//company Recover delete account by status
		public function admin_account_Recover($id){
			
			$user = User::find($id);
			$role_id = $user->role_id;
			if($user->is_deleted==1){
				$user->is_deleted = 0;
			}else {
				$user->is_deleted = 1;
			}
			
			if($user->save()){
				Session::flash('message', 'Your User Account Recover Successfully .');
				return Redirect::to('admin/users/del/'.$role_id);
			}
			
		}
		
		
		
		public function admin_select_user(){
			$user_name = Input::get('term'); 
			if($user_name=='')die;
			
			$user_data =DB::table('users')->where('users.status', 1)->where('users.role_id', 2)
			->where(function($query) use($user_name){
				$query->where('users.name', 'like',trim($user_name).'%')->orWhere('users.email', 'like',trim($user_name).'%');
			})->select('users.email', 'users.name', 'users.id')->get();
			$data = array();
			
			if($user_data){
				foreach($user_data as $val){
					$data[] = array(
					'label' => $val->name.' ( '.$val->email.' ) ',
					'value' =>$val->name.' ( '.$val->email.' ) ',
					'user_id' => $val->id
					);
				}
			}
			
			echo json_encode($data);
			flush();
			die;
		}
	}																																																																																																				