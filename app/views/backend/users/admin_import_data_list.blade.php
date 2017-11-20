@extends('backend/layouts/default')
<?php  $title = (Route::input('user_id') == 'all' OR Route::input('user_id') == 'deleted')?ucfirst(Route::input('user_id')):"";
$user_id = Route::input('user_id'); ?>
@section('title')
{{ $title}} Imported A/R data List
@stop

@section('content')
@include('backend/alert_message')
	<section class="wrapper site-min-height">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="page-title">
					@if(Route::input('user_id') != "deleted" && Auth::User()->role_id == 1 && $user_id != 'all')
						{{GeneralHelper::getCompanyNameByID(Route::input('user_id')) }}'s
					@endif
					{{ $title}} Imported A/R data List ({{ $patient->getTotal()}})
				</h3>
				<ul class="breadcrumb-new">
					<li>
						<a href="{{ URL::to('admin') }}"><i class="fa fa-home"></i></a>
						<span class="divider">&nbsp;</span>
					</li>
					<li>
						<a href="{{ URL::to('admin') }}">Dashboard</a> <span class="divider">&nbsp;</span>
					</li>
					<li>
						<a href="javascript:;">{{ $title}}  Imported A/R data List </a> 
						<span class="divider-last">&nbsp;</span>
					</li>
				</ul>
			</div>
		</div> 
		
		{{ Form::open(array('url' => array('admin/users/import_data_list/'.Route::input('user_id')),'class' => 'cmxform form-horizontal tasi-form', 'name'=>'searchPatient')) }}
			<div class="row">
				<div class="col-lg-12">
					<section class="panel">
						<h3 class="panel-heading">Search </h3>
						<div class="panel-body">
							<div class="form">
								<div class="form-group">
									<div class="col-lg-4">
										{{ Form::text('keyword', isset($_POST['keyword'])?trim($_POST['keyword']):null, array('placeholder'=>'Keyword Search', 'class' => 'form-control')) }}	
									</div>
									
									<div class="col-lg-6">
										<button class="btn btn-success" type="submit">Search</button> &nbsp;&nbsp;
										<a href="{{ URL::to('admin/users/import_data_list/'.Route::input('user_id')) }}" ><button class="btn btn-default" type="button">Show All</button></a>
									</div>
									@if(Auth::User()->role_id == 1)
										<div class="col-lg-2" style="text-align:right;">
											<a href="#remove_all" data-toggle='modal' ><button class="btn btn-danger" type="button">Delete All</button></a>
										</div>
									@endif
								</div>
								@if(Auth::User()->role_id == 1)
									<div class="modal fade" id="remove_all" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h3 class="modal-title">Remove </h3>
												</div>
												<div class="modal-body">Are you sure, you want to remove  all data ?</div>
												<div class="modal-footer">
													{{ HTML::linkAction('UserController@admin_patient_delete_all', 'Confirm', array($user_id), array('class'=>'btn btn-primary','title'=>'Confirm Remove')) }}
													<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
												</div>
											</div>
										</div>
									</div>
								@endif
							</div>
						</div>
					</section>
				</div>
			</div>
		{{ Form::close() }}
		
		<section class="panel">
			<header class="panel-heading">
				<div class="row">
					<div class="col-lg-3"><div align="left" ><h5>{{ $title}}  Imported A/R data List ({{ $patient->getTotal()}})</h5></div></div>
					<div class="col-lg-9" style="font-size:12px;"><div align="right">{{ $patient->links()}}</div></div>
				</div>
			</header>
			<!-- BEGIN PAGE HEADER-->
			
			<div class="panel-body">
				<section id="unseen">
					<div  class="table-responsive">
						<table class="table responsive-table table-bordered table-striped table-condensed">
							<thead>
								<tr>
									<th>{{ SortableTrait::link_to_sorting_action('name', 'Name' ) }}</th>
									@if(Route::input('user_id') == "deleted" OR (Route::input('user_id') == "all" and Auth::User()->role_id == 1))
										<th >{{ SortableTrait::link_to_sorting_action('User_name', 'User Name') }}</th>
									@endif
									<th >{{ SortableTrait::link_to_sorting_action('insurance_company', 'Insurance Company') }}</th>
									<th >{{ SortableTrait::link_to_sorting_action('billed_amount', 'Billed Amount') }}</th>
									<th >{{ SortableTrait::link_to_sorting_action('paid_amount', 'Paid Amount') }}</th>
									<th >{{ SortableTrait::link_to_sorting_action('AR_amount', 'AR Amount') }}</th>
									<th >{{ SortableTrait::link_to_sorting_action('date_from', 'Date From') }}</th>
									<th >{{ SortableTrait::link_to_sorting_action('date_to', 'Date To') }}</th>
									<th style="width:18%;">{{ SortableTrait::link_to_sorting_action('notes', 'Notes') }}</th>
									<th class="hidden-phone center">{{ SortableTrait::link_to_sorting_action('status', 'Status') }}</th>
									@if(Auth::User()->role_id == 1)
										<th class="center" width="7%">Action</th>
									@endif
								</tr>
							</thead>
							<tbody>	
								@if(! $patient->isEmpty())
									@foreach ($patient as $val)
								
										<tr>
											<?php /* <td>{{ HTML::linkAction('UserController@admin_view_patient', $val->name, array(Route::input('user_id'), $val->id), array( 'title'=>$val->name)) }}</td> */ ?>
											<td>{{ HTML::linkAction('UserController@admin_patient_edit', $val->name, array(Route::input('user_id'), $val->id), array( 'title'=>$val->name)) }}</td>
											@if(Route::input('user_id') == "deleted" OR (Route::input('user_id') == "all" and Auth::User()->role_id == 1))
												<td >{{ ($val->User_name)?$val->User_name:'---' }}</td>
											@endif
											<td >{{ ($val->insurance_company)?$val->insurance_company:'---' }}</td>
											<td >${{ ($val->billed_amount)?$val->billed_amount:0.00 }}</td>
											<td >${{ ($val->paid_amount)?$val->paid_amount:0.00 }}</td>
											<td >
												@if(strpos($val->AR_amount,'-') !== false )
													-${{trim($val->AR_amount,"-")}}
												@else
													${{ ($val->AR_amount)?$val->AR_amount:0.00 }}
												@endif
											</td>
											<td >{{ ($val->date_from)?date('m-d-y', strtotime($val->date_from)):'---' }}</td>
											<td >{{ ($val->date_to)?date('m-d-y', strtotime($val->date_to)):'---' }}</td>
											<td >{{ ($val->notes)?$val->notes:'---' }}</td>
											<td class="hidden-phone center">
												@if(strtolower($val->status)=='assistance')
													<span  style="color: rgb(254, 101, 33);" >&nbsp; {{ ($val->status)?$val->status:'---' }} &nbsp;</span>
												@elseif(strtolower($val->status)=='processing')
													<span style="color: rgb(51, 162, 220);" >{{ ($val->status)?$val->status:'---' }}</span>
												@elseif(strtolower($val->status)!='')
													<span style="color: rgb(66, 184, 50)">{{ ($val->status)?$val->status:'---' }}</span>
												@else
													<span >{{ ($val->status)?$val->status:'---' }}</span>
												@endif
											</td>
											@if(Auth::User()->role_id == 1)
												<td class="center">
													@if(Route::input('user_id') == "deleted")
														<a title="Deactivate" href="{{ URL::to('admin/imported_data/recover/'.$val->id) }}"><span class="label label-success label-mini">&nbsp; Recover &nbsp;</span></a>
									
														<a href="#remove_{{ $val->id }}" data-toggle='modal' class="label label-danger label-mini" title="Remove"><i class="fa fa-trash-o"></i>&nbsp;Remove </a>
														
														<div class="modal fade" id="remove_<?php echo $val->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h3 class="modal-title">Remove </h3>
																	</div>
																	<div class="modal-body">Are you sure, you want to remove this data permanentaly ?</div>
																	<div class="modal-footer">
																		{{ HTML::linkAction('AdminController@admin_data_remove', 'Confirm', array('permanent', $val->id), array('class'=>'btn btn-primary','title'=>'Confirm Remove')) }}
																		<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
																	</div>
																</div>
															</div>
														</div>
													@else
													<?php /* <a title="Update" href="{{ URL::to('admin/imported_data/edit/'.Route::input('user_id').'/'.$val->id) }}"><span class="label label-success label-mini"><i class="fa fa-edit"></i>&nbsp;Edit</span></a> */ ?>
													<a href="#remove_{{ $val->id }}" data-toggle='modal' class="label label-danger label-mini" title="Remove"><i class="fa fa-trash-o"></i>&nbsp;Remove  </a>
														
														<div class="modal fade" id="remove_<?php echo $val->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h3 class="modal-title">Remove </h3>
																	</div>
																	<div class="modal-body">Are you sure, you want to move this file under deleted accounts?</div>
																	<div class="modal-footer">
																		{{ HTML::linkAction('AdminController@admin_data_remove', 'Confirm', array('remove', $val->id), array('class'=>'btn btn-primary','title'=>'Confirm Remove')) }}
																		<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
																	</div>
																</div>
															</div>
														</div>
													@endif
												</td>
											@endif
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="11" ><p class="no-record"> No records found! </p>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					<div align="right" class="no_records" >{{ $patient->links()}}</div>
				</section>
			</div>
		</section>	
	</section>	
	<script type="text/javascript">
		
		
		$(document).ready(function() {
			
			$("#datepicker").datepicker({
				changeMonth: true,
				changeYear: true,
				format: 'yyyy-mm-dd',
				yearRange : 'c:c+50',
			});
			
			$("#datepicker1").datepicker({
				changeMonth: true,
				changeYear: true,
				format: 'yyyy-mm-dd',
				yearRange : 'c:c+50',
			});
		}); 
	</script>	
	@stop
		