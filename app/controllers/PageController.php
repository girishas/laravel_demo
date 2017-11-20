<?php
	include 'Classes/PHPExcel/IOFactory.php';
	class PageController extends BaseController {  
		public function __construct(){
			$this->beforeFilter(function(){
				
				if(Auth::guest())
				return Redirect::to('/login');
			},['except' => ['mytest', 'cron_stat']]);
		}
		
		
		public function cron_stat(){
			$date  = date('Y-m-d', strtotime('-1 months'));
			
			$clients     = DB::table('users')->where('is_deleted', '!=', 1)->where('role_id', 2)->lists('id');
			foreach($clients as $client){
				$data = DB::table('patients')->select('status', DB::raw('count(id) as val_assistance'))
												->where('company_id', $client )->where('is_deleted', 0)->whereNotNull('status')
												->whereMonth('date_from', '=', date('m', strtotime($date)))->whereYear('date_from','=', date('Y', strtotime($date)))
												->groupBy('status') ->lists('val_assistance', 'status');
				if($data){
					$isExist                = DB::table('ar_statistics')->where('company_id', $client)->whereDate('date_on', '=', date('Y-m-d'))->first();
					
					$arstat            		= ($isExist)?ARStatistic::find($isExist->id):new ARStatistic();
					$arstat->paid       	= (isset($data['Paid']) and $data['Paid'])?$data['Paid']:0;
					$arstat->assistance     = (isset($data['Assistance']) and $data['Assistance'])?$data['Assistance']:0;
					$arstat->processing     = (isset($data['Processing']) and $data['Processing'])?$data['Processing']:0;
					$arstat->company_id     = $client;
					$arstat->date_on    	= $date;
					if($arstat->save()){
						echo 'Cron has been completed successfully.'; die;
					}
				}
			}
		}
		
	}
