<?php
	use Illuminate\Auth\Reminders\RemindableTrait;
	use Illuminate\Auth\Reminders\RemindableInterface;
	use Illuminate\Support\ServiceProvider;
	
	
	class AdminController extends BaseController {   
		
		
		
		public function __construct(){
			$this->beforeFilter(function(){
				
				if(Auth::guest())
				return Redirect::to('admin');
			},['except' => ['admin_login',]]);
		}
		
		
		
		
		
		public function admin_login(){
			if(Auth::check()){
				return Redirect::to('admin/dashboard');
			}
			
			if(! empty($_POST)){
				$input = Input::all();
				$validator = User::validate('admin_login', Input::all());
				
				if ( $validator->fails() ) {
					Session::flash('message', 'Login Failed, Please correct errors');
					return Redirect::to('admin')->witherrors($validator)->withInput(Input::except('password'));
					}else {
					$usernameinput 	= Input::get('email');
					$password 		= Input::get('password');
					
					$field = filter_var($usernameinput, FILTER_VALIDATE_EMAIL) ? 'email' : 'email';
					$credentials = array('email' => Input::get('email'), 'password' => Input::get('password'));
					if (Auth::attempt(array($field => $usernameinput, 'password' => $password, 'status' => 1),true)) {	
						return Redirect::to('admin/dashboard');
						}else {		
						return Redirect::to('admin')->with('message', 'Incorrect username/password')->withInput(Input::except('password'));
					}
				}
			}
			
			return View::make('backend.users.admin_login');
		}
		
		
		public function getLogout(){
			Auth::logout();
			if (Session::has('message')){
				$message =  Session::get('message');
				return Redirect::to('admin')->with('message', $message);
				}else{
				return Redirect::to('admin');
			}
		}
		
		
		
		
		
		public function admin_update_profile(){
			$data = User::find(Auth::id());
			
			if(!empty($_POST)){
				$validator = User::validate('admin_edit', Input::all(), Auth::id());
				if ( $validator->fails() ) {
					Session::flash('message', 'Profile could not be updated, Please correct errors');
					return Redirect::to('admin/update_profile')->withErrors($validator)->withInput(Input::except('password','photo'));
					} else {
					$user = new User();
					$savedUser = $user->save_data(Input::all(), Auth::id());
					if($savedUser){
						return Redirect::to('admin/update_profile')->with('message', 'Profile has been updated successfully');
					}
					return Redirect::to('admin/update_profile');
				}
			}
			
			$users = DB::table('users')->orderBy('id', 'DESC')->get();
			return View::make('backend.users.admin_update_profile', array('data' =>$data));
			
		}
		
		
		public function admin_data_remove($slug = null, $id = null){
			$data   = Patient::find($id);
			if($slug == 'recover' OR  $slug == 'remove'){
				$data->is_deleted = ($slug == 'remove')?1:0;
				if($data->save()){
					return Redirect::to('admin/users/import_data_list/all')->with('message', 'A/R data has been '.$slug.'ed successfully.');
				}
			}elseif($slug == 'permanent'){
				if($data->delete()){
					return Redirect::to('admin/users/import_data_list/all')->with('message', 'A/R data has been removed permanently.');
				}
			}
			return Redirect::to('admin/users/import_data_list/all');
			
		}
		
		
	}	