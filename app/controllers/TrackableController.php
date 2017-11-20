<?php
	class TrackableController extends BaseController { 
		
		public function __construct(){
			$this->beforeFilter(function(){
				
				if(Auth::guest())
				return Redirect::to('/login');
			},['except' => ['']]);
		}
		
		
		//add company 
		public function admin_add(){
			/* if(Auth::User()->role_id == 2 ) {
				return Redirect::to('admin/dashboard/');
			} */
			
			if(!empty($_POST)){
				$validator = Trackable::validate('admin_add', Input::all());
				// print_r(Input::all()); die;
				
				
				if ( $validator->fails() ) {
					Session::flash('errormessage', 'Trackable could not be created, Please correct errors');
					return Redirect::to('admin/trackables/add')->withErrors($validator)->withInput(Input::except('image')); ;
					} else {
					$data = Input::all();
					$user = new User();
					$photo = Input::file('image');
					if($photo){
						$photo_name = $user->saveProfileImage($photo,  'trackable', Config::get('constants.TRACKABLE_THUMB_WIDTH'));
						$data['image'] = $photo_name;
					}
					
					$Trackable = new Trackable();
					$savedTrackable = $Trackable->create($data);
				 
					if ($savedTrackable){
						return Redirect::to('admin/trackables')->with('message', 'Trackable has been created successfully.');
					}
					return Redirect::to('admin/trackables');
				}
			}
			return View::make('backend.trackables.admin_add');
		}
		
		
		
		//company list 
		public function admin_index($role_id = null){
			
			if(Auth::User()->role_id == 2 ) {
				return Redirect::to('admin/dashboard/');
			} 
			
			
			if (Session::has('usearch') and (isset($_GET['page']) and $_GET['page']>=1) OR (isset($_GET['s']) and $_GET['s'])) {
				$_POST = Session::get('usearch');
			}
			
			$Trackable = Trackable::sortable() ;
			
			if(! empty($_POST)){
				if(isset($_POST['name']) and $_POST['name'] !=''){
					$name = $_POST['name'];
					Session::put('usearch.name', $name);
					$Trackable = $Trackable->where('trackables.name', 'like', trim($name)."%");
				}
				if(isset($_POST['alert']) and $_POST['alert'] !=''){
					$alert = $_POST['alert'];
					Session::put('usearch.alert', $alert);
					$Trackable = $Trackable->where('trackables.alert', 'like', trim($alert)."%");
				}
			}else{
				Session::forget('usearch');
			}
			
			$users = $Trackable->orderBy('id', 'DESC')->paginate(Config::get('constants.PAGINATION'));
			
			if(isset($_GET['s']) and $_GET['s']){
				$users->appends(array('s' => $_GET['s'],'o'=>$_GET['o']))->links();
			}
			
			return View::make('backend.trackables.admin_index', compact('users'));
			
		}
		
		
		//company status
		public function admin_status($id){
			$Trackable = Trackable::find($id);
			if($Trackable->status==1){
				$Trackable->status = 0;
				}else {
				$Trackable->status = 1;
			}
			
			if($Trackable->save()){
				Session::flash('message', 'Status has been changed successfully!');
				return Redirect::to('admin/trackables');
			}
			
		}
		//company edit
		public function admin_edit($id = null) {
			$Trackable = Trackable::find($id);
			if(Auth::User()->role_id == 2 OR !$Trackable) {
				return Redirect::to('admin/dashboard/');
			}
			
			$Trackable = Trackable::find($id);
			if(!empty($_POST)){
				$validator = Trackable::validate('admin_edit', Input::all(), $id);
			
				if ( $validator->fails() ) {
					Session::flash('errormessage', 'Trackables could not be updated, Please correct errors');
					return Redirect::to('admin/trackables/edit/'.$id)->withErrors($validator)->withInput(Input::except('image'));
					} else {
					$data = Input::all();
					$user = new User();
					$photo = Input::file('image');
					
					if($photo){
						if($Trackable->image!='' && file_exists('upload/trackable/large/'.$Trackable->image)){
								unlink('upload/trackable/large/'.$Trackable->image);
								unlink('upload/trackable/thumb/'.$Trackable->image);
							}
						$photo_name = $user->saveProfileImage($photo,  'trackable', Config::get('constants.TRACKABLE_THUMB_WIDTH'));
						$data['image'] = $photo_name;
					}
					else{
						unset($data['image']);
					}
					
					
					$savedTrackable = $Trackable->update($data);
					
					if ($savedTrackable){
						return Redirect::to('admin/trackables')->with('message', 'Trackable has been updated successfully');
					}
					else{
						return Redirect::to('admin/trackables/edit/')->with('message', 'Trackable could not be added, please try again.');
					}
				}
			}
			return View::make('backend.trackables.admin_edit',compact('Trackable'));
		}
		
		
		
		//company single profile view
		public function admin_view($id=null){
			if(Auth::User()->role_id ==2 ) {
				return Redirect::to('admin/dashboard/');
			} else {
				$Trackable = DB::table('trackables')->where('id', $id )->orderBy('id', 'DESC')->first();
				return View::make('backend.trackables.admin_view', compact('Trackable'));
				//print_r($trackables); die;
			}
		} 
		
		
		//company remove by status
		public function admin_remove($id){
			$Trackable = Trackable::find($id);		
			
			if($Trackable->delete()){
				Session::flash('message', 'User account  has been deleted successfully.');
				return Redirect::to('admin/trackables');
			}			
		}
		
		//assigning users
		public function admin_assign_users($id=null){
			if(Auth::User()->role_id == 2 ) {
				return Redirect::to('admin/dashboard/');
			}
			
			$users = DB::table('users')->where('status', 1)->where('role_id', '<>', '1')->lists('name','id');			
			
			$already_users = DB::table('trackable_users')->where('trackable_id', $id)->lists('user_id');
			
			if(!empty($_POST)){	
				$usersm = Input::get('my_multi_select1')?Input::get('my_multi_select1'):array();
				$deletedUsers = array_diff($already_users, $usersm);
				DB::table('trackable_users')->where('trackable_id', $id)->whereIn('user_id', $deletedUsers)->delete();
				
				foreach($usersm as $user)
				{
					if(!in_array($user, $already_users)){
						$data = array('user_id'=>$user,'trackable_id'=>$id);
						$savedTrackusers = TrackableUser::create($data);
					}
				}
					return Redirect::to('admin/trackables/assign_users/'.$id)->with('message','trackable user have been successfull saved');	
			}
			return View::make('backend.trackables.admin_assign_users', compact('users'));
		}
		
		
		public function admin_dashboard_index($user_id = null, $trackable_id = null){
				if(Auth::User()->role_id == 2 and Auth::id() != $user_id) {
					return Redirect::to('admin/dashboard/');
				}
				$users = DB::table('users')->where('id',$user_id)->orderBy('id', 'DESC')->first();
				
				if($users){
					$Trackable_values = TrackableValue::sortable()->where('user_id', $user_id );
					if($trackable_id){
						$Trackable_values = $Trackable_values->where('trackable_id', $trackable_id );
					}
					
					$Trackable_values = $Trackable_values->leftjoin('trackables','trackables.id','=','trackable_values.trackable_id')
					->select('trackable_values.*','trackables.name','trackables.alert')->orderBy('created_at', 'DESC')->paginate(Config::get('constants.PAGINATION'));
					//echo  "<pre>"; print_r($Trackable_values); die;
				}else{
					return Redirect::to('admin/dashboard/')->with('errormessage', 'Invalid URL.');
				}
			
			return View::make('backend.trackables.admin_dashboard_index', compact('Trackable_values','users'));
		}
		
		public function admin_dashboard_remove($id){
			//$Trackable = Trackable::find($id);		
			$Trackable =TrackableUser::where('id',$id)->first();
			$user_id = $Trackable->user_id;
			
			if ($Trackable != null) {
				$Trackable->delete();
				Session::flash('message', 'This trackable has been removed for this user.');
				return Redirect::to('admin/trackables/dashboard_index/'.$user_id);
			}			
		}
		
		public function admin_dashboard_remove_view($id){
			//$Trackable = Trackable::find($id);		
			$Trackable =TrackableValue::find($id);
			$user_id = $Trackable->user_id;
			$trackable_id = $Trackable->trackable_id;
			
			if ($Trackable != null) {
				$Trackable->delete();
				Session::flash('message', 'Trackable value has been deleted successfully.');
				return Redirect::to('admin/trackables/dashboard_view/'.$user_id.'/'.$trackable_id);
			}			
		}
		
	}																																																																																																				