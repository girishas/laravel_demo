<?php
	class WebController extends BaseController { 
		
		/* 	user login
		Input: email, password
		Table: users
		Output: user info all */
		
		public function mobi_login(){
			$result 			= array();   
			
			if(isset($_POST['ios']) and $_POST['ios']==1){
				$credentials = array('email' => $_POST['email'], 'password' => $_POST['password'], 'status' => 1);
			}else{
				$json  			 	= file_get_contents('php://input');
				$obj    			= json_decode($json, true);    
				$credentials = array('email' => $obj['email'], 'password' => $obj['password'], 'status' => 1); 
			}
			
			
			if (Auth::attempt($credentials, true)) {	
				$user = DB::table('users')->where('users.id', Auth::id())->first();
				User::where('id', $user->id)->update(array('updated_at'=>date('Y-m-d H:i:s')));
				$result = array('type'=>'success', 'data'=>$user,"path"=>Config::get('constants.SITE_URL')."/upload/users/profile-photo/large/");					
			}else {		
				$result = array('type'=>'error', 'data'=>'Incorrect username/password');
			}
			echo json_encode($result); die;
		}
		
		
		/* 	user update profile
		Input: user_id + all information
		Table: users
		Output: update user info all */
		
		public function mobi_update_profile(){
			$result 			= array();   
			if(isset($_POST['ios']) and $_POST['ios']==1){
				$obj			   	= $_POST ;
			}else{
				$json  			 	= file_get_contents('php://input'); 	
				$obj			   	= json_decode($json, true);    
			}
			 $user_id			= $obj['user_id']; 
			
			$email				= isset($obj['email'])?$obj['email']:"";
			$exit_User = 0;
			if($email){
				$exit_User  		= DB::table('users')->where('id','<>',$user_id)->where('email', $email)->count();
			}
		
			if($exit_User > 0){
				$result = array("type" => "error", "data" => 'Email is already exist in the system.');
			}else{
				$user 				= User::find($user_id);
				$userUpdated 		= $user->update($obj); 
				if($userUpdated) {
					$result = array("type" => "success", "data" => 'Profile has been updated successfully.');
				}else{
					$result = array("type" => "error", "data" => 'Oops ! something is went wrong, please try again.');
				}
			}
			
			echo json_encode($result);  die; 				
		}
		
		
		
		
		/* 	User change password
		Input: user_id + new_password
		Table: users
		Output: update user password */
		
		public function mobi_change_password(){
			$result 	= array();   
			if(isset($_POST['ios']) and $_POST['ios']==1){
				$obj			   	= $_POST ;
			}else{
				$json  			 	= file_get_contents('php://input'); 	
				$obj			   	= json_decode($json, true);    
			}
			
	 
			$id			= $obj['user_id'];
			$password	= Hash::make($obj['new_password']);
			$user 		= User::where('id', $id)->update(array('password' => $password));
			echo $user; die;
			if($user){
				$result = array('type'=>'success', 'data'=>"Password has been changed successfully.");					
			}else {		
				$result = array('type'=>'error', 'data'=>'Oops! something went wrong, please try again.');
			}
			echo json_encode($result); die;
			
		}
		
		
		
		/* 	get all AR accounts list
		Input: user_id + next_page
		Table: patients
		Output: show lists of A/R Accounts */
		
		public function mobi_all_imported_data(){
			$result 		= array();   
			if(isset($_POST['ios']) and $_POST['ios']==1){
				$obj			   	= $_POST ;
			}else{
				$json  			 	= file_get_contents('php://input'); 	
				$obj			   	= json_decode($json, true);    
			}
			$company_id		= $obj['user_id'];
			$limit			= 20;
			$next_page		= (isset($obj['next_page']) and $obj['next_page'])?$obj['next_page']:1;
			$skip			= $limit*($next_page-1);
			
			
			$data['Patient']  = DB::table('patients')->where('company_id', $company_id)->where('is_deleted', '!=', 1)->take($limit)->skip($skip)->get();
			$dataArr 		  = DB::table('patients')->where('company_id', $company_id)->where('is_deleted', '!=', 1)->paginate($limit);
			$total_page  =  $dataArr->getLastPage();
			
			if($data['Patient']){
				if($total_page > $next_page){
					$data['next_page']  = $next_page + 1;
				}
				$data['total_page']  = $total_page;
				$result = array('type'=>'success', 'data'=>$data);					
			}else {		
				$result = array('type'=>'error', 'data'=>'No A/R account found.');
			}
			echo json_encode($result); die;
		}
		
		
		/* 	Searching AR account
		Input: user_id + name + date_from + date_to + status + next_page
		Table: patients
		Output: All matched AR Accounts */
		
		public function mobi_search_imported_data(){
			$result 		= array();   
			if(isset($_POST['ios']) and $_POST['ios']==1){
				$obj			   	= $_POST ;
			}else{
				$json  			 	= file_get_contents('php://input'); 	
				$obj			   	= json_decode($json, true);    
			}
			$company_id		= $obj['user_id'];
			$name			= isset($obj['name'])?$obj['name']:'';
			$date_from		= isset($obj['date_from'])?$obj['date_from']:'';
			$date_to		= isset($obj['date_to'])?$obj['date_to']:'';
			$status			= isset($obj['status'])?$obj['status']:'';
			
			$limit			= 20;
			$next_page		= (isset($obj['next_page']) and $obj['next_page'])?$obj['next_page']:1;
			$skip			= $limit*($next_page-1);
			
			
			$data_patient  = DB::table('patients')->where('company_id', $company_id)->where('is_deleted', '!=', 1);
			if($name){
				$data_patient  = $data_patient->where(function($query) use($name){ $query->where('name', 'like', $name."%")->orWhere('insurance_company', $name); });
			}
			
			if($status){
				$data_patient  = $data_patient->where('status', $status);
			}
			
			if($date_from and $date_to){
				$data_patient  = $data_patient->whereDate('date_from', '>=', $date_from)->whereDate('date_to', '<=', $date_to);
			}elseif($date_from){
				$data_patient  = $data_patient->whereDate('date_from', '>=', $date_from);
			}elseif($date_to){
				$data_patient  = $data_patient->whereDate('date_to', '<=', $date_to);
			}
			
			$dataDummmy          = $data_patient;
			$data_patient 		 = $data_patient->take($limit)->skip($skip)->get();
			$data['Patient'] 	 = $data_patient;
			
			$dataArr 		  	 = $dataDummmy->paginate($limit);
			$total_page 		 =  $dataArr->getLastPage();
			
			if($data['Patient']){
				if($total_page > $next_page){
					$data['next_page']  = $next_page + 1;
				}
				$data['total_page']  = $total_page;
				$result = array('type'=>'success', 'data'=>$data);					
			}else {		
				$result = array('type'=>'error', 'data'=>'No A/R account found.');
			}
			echo json_encode($result); die;
		}
		
		
		
		/* 	update AR notes
		Input: user_id + AR_Account_ID + notes
		Table: patients
		Output: append notes */
		
		public function mobi_update_notes(){
			$result 		= array();   
			if(isset($_POST['ios']) and $_POST['ios']==1){
				$obj			   	= $_POST ;
			}else{
				$json  			 	= file_get_contents('php://input'); 	
				$obj			   	= json_decode($json, true);    
			}
			$company_id		= $obj['user_id'];
			$id				= $obj['AR_Account_ID'];
			$notes			= (isset($obj['notes']) and $obj['notes']!="")?$obj['notes']:'';
			
			$patient        = Patient::where('company_id',$company_id)->where('id',$id)->first();
			
			if($patient){
			if($notes){
				$notes_update = substr($notes, -2);
				if(trim($notes_update)==']')
				{ 
					$patient->notes    		= $patient->notes;
				}else{
					$patient->notes    		= $patient->notes." ".$notes.""; 
					$patient->notes_updated = "1";
				}	
				
				if($patient->save()){  
					$result = array('type'=>'success', 'data'=>"Notes has been updated successfully.");	
				}else {		
					$result = array('type'=>'error', 'data'=>'Oops! something went wrong, please try again.');
				}
			}else{
				$result = array('type'=>'error', 'data'=>'Notes should not be empty.');
			}
			
			}else{
				$result = array('type'=>'error', 'data'=>'AR account not found.');
			}
				
			
			echo json_encode($result); die;
		}
		
		
		
		/* 	Get user Dashboard
		Input: user_id
		Table: patients
		Output: post graph data */
		
		public function mobi_dashboard(){
			$result 		= array();   
			if(isset($_POST['ios']) and $_POST['ios']==1){
				$obj			   	= $_POST ;
			}else{
				$json  			 	= file_get_contents('php://input'); 	
				$obj			   	= json_decode($json, true);    
			}
			$company_id		= $obj['user_id'];
			$user           = User::find($company_id);
			$first_day = strtotime(date('1-m-Y', strtotime("-1 months"))); 
			$last_day  = strtotime(date('d-m-Y',  strtotime("-1 months")));
			
			$datesArr = array(); $barData = array(); $graphData = array();
			for ($i=$first_day; $i<=$last_day; $i+=86400) {  
				$datesArr[] 									= date("Y-m-d", $i);  
				$graphData['Paid'][date("Y-m-d", $i)] 			= 0;
				$graphData['Processing'][date("Y-m-d", $i)] 	= 0;
				$graphData['Assistance'][date("Y-m-d", $i)] 	= 0;
			} 
			
			$date  = date('Y-m-d', strtotime('-1 months'));
			$data = DB::table('patients')->select('status', DB::raw('count(id) as val_assistance'))
											->where('company_id', $company_id )->where('is_deleted', 0)->whereNotNull('status')
											->whereMonth('date_from', '=', date('m', strtotime($date)))->whereYear('date_from','=', date('Y', strtotime($date)))
											->groupBy('status') ->lists('val_assistance', 'status');
			
			if($data){
				$isExist                = DB::table('ar_statistics')->where('company_id', $company_id)->whereDate('date_on', '=', $date)->first();
				$arstat            		= ($isExist)?ARStatistic::find($isExist->id):new ARStatistic();
				$arstat->paid       	= (isset($data['Paid']) and $data['Paid'])?$data['Paid']:0;
				$arstat->assistance     = (isset($data['Assistance']) and $data['Assistance'])?$data['Assistance']:0;
				$arstat->processing     = (isset($data['Processing']) and $data['Processing'])?$data['Processing']:0;
				$arstat->company_id     = $company_id;
				$arstat->date_on    	= $date;
				$arstat->save();
			}
			
			
			
			$barData   = DB::table('ar_statistics')->whereMonth('date_on', '=', date('m', strtotime($date)))->whereYear('date_on', '=', date('Y', strtotime($date)))->where('company_id', $company_id);
			$barData   = $barData->select('date_on', DB::raw('sum(paid) as total_paid'), DB::raw('sum(processing) as total_processing'), DB::raw('sum(assistance) as total_assistance'));
			$barData   = $barData->orderBy('date_on', 'ASC')->groupBy('date_on')->get();
			
			foreach($barData as $val){
				$valDate   								= $val->date_on;
				$graphData['Paid'][$valDate] 			= $val->total_paid;
				$graphData['Processing'][$valDate] 		= $val->total_processing;
				$graphData['Assistance'][$valDate] 		= $val->total_assistance;
			}
			$graphData['Paid']   		= array_values($graphData['Paid']);
			$graphData['Processing']    = array_values($graphData['Processing']);
			$graphData['Assistance']    = array_values($graphData['Assistance']);
			$resultData['LineGraph']				= $graphData;
			
			$before_date  = date('Y-m-t', strtotime('-2 months'));
			
			$resultData['BarGraph'] = DB::table('patients')->select('status', DB::raw('count(id) as val_assistance'))
											->where('company_id', $company_id )->where('is_deleted', 0)->whereNotNull('status')
											->whereDate('date_from', '<=', $before_date)->groupBy('status') ->lists('val_assistance', 'status');
			
			
			if($resultData){
				$result = array('type'=>'success', 'data'=>$resultData);	
			}else {		
				$result = array('type'=>'error', 'data'=>'Oops! something went wrong, please try again.');
			}
			echo json_encode($result); die;
		}	
		
		
		/* 	Upload User Image
		Input: user_id, image_code, ext
		Table: users
		Output: upload image */
		public function mobi_upload_image(){
			// print_r($_FILES) ; die;
			$result = array();
			if(isset($_POST['ios']) and $_POST['ios']==1){
			   
				$id     = (isset($_POST['user_id']) and $_POST['user_id']!='')?$_POST['user_id']:""; 
				$ext = (isset($_POST['ext']) and $_POST['ext']!='')?'.'.$_POST['ext']:'.jpg'; 
				$file_name = 'image_'.$_POST['user_id'].rand(1000,9999).$ext ;  
				$uploadfile = 'upload/users/profile-photo/large/'.$file_name;   
				if (move_uploaded_file($_FILES['image_code']['tmp_name'], $uploadfile)) {
				
				}else{
					$result = array('type'=>'error','data' => 'Photo upload failed.');
					echo json_encode($result); die;
				} 
				
			
			}else{
				$json  			 	= file_get_contents('php://input'); 	
				$obj			   	= json_decode($json, true);    
				$id     = (isset($obj['user_id']) and $obj['user_id']!='')?$obj['user_id']:""; 
				$ext = (isset($obj['ext']) and $obj['ext']!='')?'.'.$obj['ext']:'.jpg'; 
				$file_name = 'image_'.$obj['user_id'].rand(1000,9999).$ext ; 
				$binary=base64_decode($obj['image_code']);  
				
				header('Content-Type: bitmap; charset=utf-8');
				$file = fopen('upload/users/profile-photo/large/'.$file_name, 'wb');
				fwrite($file, $binary);
				fclose($file); 
				
			
			}
				
				if($id ==''){
					$result = array('type'=>'error','data' => 'User Id missing.');
					echo json_encode($result); die;
				} 
			
			
			$user  			 = User::find($id);
			$user->photo 	= $file_name;
			
			if($user->save()){
				$image_url = Config::get('constants.SITE_URL').'/upload/users/profile-photo/large/'.$file_name;
				$result = array('type'=>'success','data' =>$image_url);
			}else{
				$result = array('type'=>'error','data' => 'Photo upload failed.');
			} 
			echo json_encode($result); die;
		}
	}																																																																																																				