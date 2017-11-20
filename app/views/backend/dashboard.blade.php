@extends('backend/layouts/default')
@section('content')
	@include('backend/alert_message')
	<style>
		canvas{
		-moz-user-select: none;
		  -webkit-user-select: none;
		  -ms-user-select: none;
		}
		#chartjs-tooltip {
		  opacity: 1;
		  position: absolute;
		  background: rgba(0, 0, 0, .7);
		  color: white;
		  border-radius: 3px;
		  -webkit-transition: all .1s ease;
		  transition: all .1s ease;
		  pointer-events: none;
		  -webkit-transform: translate(-50%, 0);
		  transform: translate(-50%, 0);
		}

		.chartjs-tooltip-key {
		  display: inline-block;
		  width: 10px;
		  height: 10px;
		}
	</style>
	<section class="wrapper site-min-height"> <?php 
		$cancerKiller_value_string		= implode(",",$graphData['cancerKiller']);
		$weightControl_value_string		= implode(",",$graphData['weightControl']);
		$heartHappy_value_string		= implode(",",$graphData['heartHappy']);
		$moodMeter_value_string			= implode(",",$graphData['moodMeter']);
		
		$date = implode(",", $datesArr);
		
		$dashboard_id  = Route::input('trackable_id'); ?> 
		
		<div class="row">
			<div class="col-lg-12">
				<h3 class="page-title">
					@if(Auth::User()->role_id == 1)
						Dashboard
					@else
						Dashboard :: {{($dashboard_id)?GeneralHelper::getTrackbleName($dashboard_id):"All Trackbales" }}
					@endif
				</h3>
			</div>
		</div>
		
		@if(Auth::User()->role_id != 1)
			<div class="row state-overview">
				<a href ="{{ URL::to('admin/trackables/dashboard_index/'.Auth::id().'/'.$dashboard_id)}}">
					<div class="col-lg-3 col-sm-6">
						<section class="panel">
							<div class="symbol blue" style="background: rgb(130, 50, 30);">
								{{HTML::image('img/fist.png', '', array('style' => 'width:49px;'))}}
							</div>
							<div class="value">
								<h1 class="count">{{ $data->total_cancer_killer?$data->total_cancer_killer:0}}</h1>
								<p><strong>Cancer Killer </strong></p>
							</div>
						</section>
					</div>
				</a>
				
				
				<a href ="{{ URL::to('admin/trackables/dashboard_index/'.Auth::id().'/'.$dashboard_id)}}">
					<div class="col-lg-3 col-sm-6">
						<section class="panel">
							<div class="symbol blue" style="background: rgb(51, 162, 220);">
								{{HTML::image('img/weight_scale.png', '', array('style'=>"width:49px;"))}}
							</div>
							<div class="value">
								<h1 class="count">{{$data->total_weight_control?$data->total_weight_control:0}}</h1>
								<p><strong>Weight Control </strong></p>
							</div>
						</section>
					</div>
				</a>
			
				<a href ="{{ URL::to('admin/trackables/dashboard_index/'.Auth::id().'/'.$dashboard_id)}}">
					<div class="col-lg-3 col-sm-6">
						<section class="panel">
							<div class="symbol blue" style="background: rgb(254, 0, 0);">
								<i class="fa fa-heart-o"></i>
							</div>
							<div class="value">
								<h1 class="count">{{$data->total_happyheart?$data->total_happyheart:0}}</h1>
								<p><strong>Heart Happy</strong></p>
							</div>
						</section>
					</div>
				</a>
				
				<a href ="{{ URL::to('admin/trackables/dashboard_index/'.Auth::id().'/'.$dashboard_id)}}">
					<div class="col-lg-3 col-sm-6">
						<section class="panel">
							<div class="symbol blue" style="background: rgb(66, 184, 50);">
								<i class="fa fa-smile-o"></i>
							</div>
							<div class="value">
								<h1 class="count">{{$data->total_moodmeter?$data->total_moodmeter:0}}</h1>
								<p><strong>Mood Meter</strong></p>
							</div>
						</section>
					</div>
				</a>
			</div> 
		@endif
		
		<div class="row state-overview"> 
			<div class="{{(Auth::User()->role_id == 1)?'col-lg-12':'col-lg-8 col-sm-8' }}">
				@if(Auth::User()->role_id != 1)
					<div id="canvas-holder1">
						<canvas id="chart1"></canvas>  
					</div>
				@endif
				
				@if(Auth::User()->role_id == 1)
					<section class="panel">
						<header class="panel-heading">Users</header>
						<div class="panel-body">
							<section id="unseen">
								<table class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th>#</th>
											<th>{{ SortableTrait::link_to_sorting_action('name', 'Name' ) }}</th>
											<th class="hidden-phone">{{ SortableTrait::link_to_sorting_action('email', 'Email') }}</th>
											<th class="hidden-phone">{{ SortableTrait::link_to_sorting_action('mobile', 'Mobile') }}</th>
											<th class="hidden-phone center">{{ SortableTrait::link_to_sorting_action('status', 'Status') }}</th>
										</tr>
									</thead>
									<tbody>	
										@if(! $users->isEmpty()) <?php
											$record_id  = ($users->getCurrentPage()*10-10)+1; ?>
											@foreach ($users as $val)
												<tr>
													<?php $name = ucwords(strtolower($val->name )); ?>
													<td>{{$record_id}}</td>
													<td>
														{{ HTML::linkAction('TrackableController@admin_dashboard_index', $name, array($val->id), array( 'title'=>$name)) }}
													</td>
													<td class="hidden-phone">{{  $val->email }}</td>
													<td class="hidden-phone">{{ ($val->mobile)?$val->mobile:'---' }}</td>
													<td class="hidden-phone center">
														@if($val->status==1)
															<span class="label label-success label-mini">&nbsp; Active &nbsp;</span>
														@else
															<span class="label label-danger label-mini">Deactivate</span>
														@endif
													</td>
												</tr> <?php $record_id++; ?>
											@endforeach
										@else
											<tr>
												<td colspan="6" ><p class="no-record"> No records found! </p>
											</tr>
										@endif
									</tbody>
								</table>
								<div align="right" class="no_records" >{{ $users->links()}}</div>
							
							</section>
						</div>
					</section>	
				@else
					<section class="panel" style="margin-top:30px;">
						<header class="panel-heading">Trackbales</header>
						<a href="{{ URL::to('admin/trackables/add') }}" style="float: right; margin-top: -38px; margin-right: 20px;" >
							<button class="btn btn-info" type="button">Add New Trackable</button>
						</a>
						<div class="panel-body">
							<section id="unseen">
								<table class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th class="hidden-phone">Alert Frequency</th>
											<th class="hidden-phone">Logic</th>
											<th class="hidden-phone center">Unit</th>
										</tr>
									</thead>
									<tbody>	
										@if($trackables) <?php
											$record_id  = 1; ?>
											@foreach ($trackables as $val)
												@if(in_array($val->id, $trackable_users))
													<tr>
														<?php $name = ucwords(strtolower($val->name )); ?>
														<td>{{$record_id}}</td>
														<td>
															<a href="{{URL::to('admin/dashboard/'.$val->id)}}">{{$name}}</a>
														</td>
														<td class="hidden-phone">{{  date('H:i A', strtotime($val->alert_frequence)) }}</td>
														<td class="hidden-phone">{{ ($val->logic_if_greaterthen)?$val->logic_if_greaterthen:'---' }}</td>
														<td class="hidden-phone center">{{$val->unit?$val->unit:'----'}}</td>
													</tr> <?php $record_id++; ?>
												@endif
											@endforeach
										@else
											<tr>
												<td colspan="6" ><p class="no-record"> No trackables found! </p>
											</tr>
										@endif
									</tbody>
								</table>
							</section>
						</div>
					</section>	
				@endif
			</div>
			@if(Auth::User()->role_id == 2)
				<div class="col-sm-4">
					<section class="panel panel-default">
						<header class="panel-heading">Alerts</header>
						<div class="panel-body">
							@if($trackables)
								
								@foreach ($trackables as $val)
									<div class="alert alert-info alert-block fade in" style="margin:4px 0px;">
										<div class="row">
											<div class="col-lg-11" style="padding-right:0px;">
												@if(Auth::User()->role_id != 1 and in_array($val->id, $trackable_users))
													<a href="javascript:void(0);" onclick="fillAlertBox({{$val->id}},'{{$val->alert}}');">{{$val->alert}}</a>
												@else
													{{$val->alert}}
												@endif
											</div>
											<div class="col-lg-1" style="padding-left:0px;">
												@if(Auth::User()->role_id == 2)
													@if(in_array($val->id, $trackable_users))
														<a title="Remove" style="float:right;position:relative;top:5px;"  href="{{URL::to('admin/trackbles_users_status/'.$val->id.'/'.$dashboard_id)}}">
															<span class="fa fa-times-circle" style="font-size:24px;color:red;"></span>
														</a>
													@else
														<a title="Add" style="float:right;position:relative;top:5px;" href="{{URL::to('admin/trackbles_users_status/'.$val->id.'/'.$dashboard_id)}}">
															<span class="fa fa-check-circle green" style="font-size:24px"></span>
														</a>
													@endif
												@endif
											</div>
										</div>
									</div>
								@endforeach
							@else
								<div class="alert alert-info alert-block fade in" >
									<button data-dismiss="alert" class="close close-sm" type="button">
										<i class="fa fa-times"></i>
									</button>
									<p>No alerts yet.</p>
								</div>
							@endif
						</div>
					</section>
				</div>
			@endif
		</div> 
		<br /><br />  
	</section> 
	
	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="trackable_show_modal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" aria-label="Close" data-dismiss="modal" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
					<h4 class="modal-title" id="modal_title"></h4>
				</div>
				{{ Form::open(array('url' => 'admin/trackable_values/'.$dashboard_id, 'id' => 'template_form')) }}
					<div class="modal-body">
						{{Form::hidden('trackable_id', null, array("id"=>"trackable_id"))}}
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="value" class="control-label col-lg-3 right"> Value<span class='red bold'>*</span></label>
									<div class="col-lg-9">
										{{ Form::text('value', null, array('class' => 'form-control',"id"=>"trackable_value"))}}
										<span class="red">{{ $errors->first('value')}}</span>
									</div>
								</div>	
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="date_e" class="control-label col-lg-3 right"> Date<span class='red bold'>*</span></label>
									<div class="col-lg-9">
										{{ Form::text('date_e', date('Y-m-d'), array('class' => 'form-control datepicker',"id"=>"date_created"))}}
										<span class="red">{{ $errors->first('date_e')}}</span>
									</div>
								</div>	
							</div>
						</div>
					</div>
					<div class="modal-footer" style="margin-top:10px;">
						<button class="btn btn-info" type="submit">Submit</button> 
					</div>
				{{Form::close()}}
			</div>
		</div>
	</div>
	@if(Auth::User()->role_id != 1)
		<script>
			Chart.defaults.global.pointHitDetectionRadius = 1;
			var chart_date = '<?php echo $date; ?>';
			var splitted_date = chart_date.split(",");
			
			var cancerKiller_value_string = '<?php echo $cancerKiller_value_string; ?>';
			var splitted_cancerKiller_vlaue = cancerKiller_value_string.split(",");
			
			var weightControl_value_string = '<?php echo $weightControl_value_string; ?>';
			var splitted_weightControl_vlaue = weightControl_value_string.split(",");
			
			var heartHappy_value_string = '<?php echo $heartHappy_value_string; ?>';
			var splitted_heartHappy_vlaue = heartHappy_value_string.split(",");
			
			var moodMeter_value_string = '<?php echo $moodMeter_value_string; ?>';
			var splitted_moodMeter_vlaue = moodMeter_value_string.split(",");
			
			
			var config = {
				type: 'line',
				data: {
					labels: splitted_date,
					
					datasets: [ 
						{label: "Cancer Killer",data: splitted_cancerKiller_vlaue},
						{label: "Weight Control", data: splitted_weightControl_vlaue},
						{label: "Heart Happy",data: splitted_heartHappy_vlaue},
						{label: "Mood Meter",data: splitted_moodMeter_vlaue}
					]
				},
				options: {
					responsive: true,
					
					title: {
						display: true,
						text: ''
					}
				}
			};
			
			
			jQuery.each(config.data.datasets, function(i, dataset) {
				var backgroundArr = ["rgba(130, 50, 30, 0.3)", "rgba(51, 162, 220, 0.3)","rgba(254, 0, 0, 0.3)","rgba(66, 184, 50, 0.3)"];
				var backgroundArr2 = ["rgba(130, 50, 30, 1)", "rgba(51, 162, 220, 1)","rgba(254, 0, 0, 1)","rgba(66, 184, 50, 1)"];
				var background = backgroundArr[i];
				var background2 = backgroundArr2[i];
				dataset.borderColor = background2;
				dataset.borderWidth = 2;
				dataset.backgroundColor = background;
				dataset.pointBorderColor = background2;
				dataset.pointBackgroundColor = "#F1F2F7";
				dataset.pointBorderWidth = 1;
			});
			
			window.onload = function() {
				var ctx = document.getElementById("chart1");
				window.myLine = new Chart(ctx, config);
				
			};
			
			jQuery(document).ready(function(){
				
				<?php 
				if(Auth::User()->role_id == 2){
					foreach($trackable_alert as $alert){
						$new_alerts = Session::get('my_trackable')?Session::get('my_trackable'):array();
						if(!in_array($alert->id, $new_alerts)) { ?>
							setTimeout(function () {
								jQuery('#trackable_show_modal').modal('show') ;
								jQuery('#trackable_id').val("<?php echo $alert->id; ?>");
								jQuery('#modal_title').html("<?php echo $alert->alert; ?>");
							}, 1000); <?php 
						} 
					}
				}?>
				jQuery( ".datepicker" ).datepicker({
					format: 'yyyy-mm-dd',
					autoclose : true
				});
			});
			
			function fillAlertBox(id, alert){
				jQuery('#trackable_show_modal').modal('show') ;
				jQuery('#trackable_id').val(id);
				jQuery('#modal_title').html(alert);
			}
		</script>
		@endif
	@stop