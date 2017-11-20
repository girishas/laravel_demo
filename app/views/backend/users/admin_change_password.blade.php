@extends('backend/layouts/default')
@section('title')
	{{ Config::get('constants.USER_ROLES.'.Auth::User()->role_id) }} Management 
@stop
<?php
$role_id = Route::input('role_id');
$data_role =  Config::get('constants.USER_ROLES.'.$role_id); 
$data_role  = str_plural($data_role); ?>

@section('content')

@include('backend/alert_message')

<section class="wrapper site-min-height">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-title">
				Change Password
			</h3>
			<ul class="breadcrumb-new">
				<li>
					<a href="{{ URL::to('admin') }}"><i class="fa fa-home"></i></a>
					<span class="divider">&nbsp;</span>
				</li>
				<li>
					<a href="{{ URL::to('admin/dashboard/') }}">Dashboard</a> <span class="divider">&nbsp;</span>
				</li>
				
				<li>
					<a href="javascript:;">{{ 'Change Password : '.$data->name }}</a> 
					<span class="divider-last">&nbsp;</span>
				</li>
			</ul>
		</div>
	</div>
	
	@if($data->role_id != 1 and Auth::User()->role_id == 1)
		@include('Elements/User/top_link')
	@endif
  <!-- page start-->
	<div class="row">
		{{ Form::model($data,array('url' => array('admin/users/change_password',$data->role_id, $data->id), 'method' => 'PUT', 'class' => 'cmxform form-horizontal tasi-form')) }}
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading">
						Change Password : {{$data->first_name .' '. $data->last_name}}
					</header>
					<div class="panel-body">
						<div class="form">
							<div class="form-group ">
								<label for="password" class="control-label col-lg-2">New Password<span class='red bold'>*</span></label>
								<div class="col-lg-4">
									{{ Form::password('password',  array('class' => 'form-control'))}}
									<span class="red">{{ $errors->first('password')}}</span>
								</div>
								<div class="col-lg-6"></div>
							</div>
							
							<div class="form-group ">
								<label for="password" class="control-label col-lg-2">Confirm Password<span class='red bold'>*</span></label>
								<div class="col-lg-4">
									{{ Form::password('password_confirmation',  array('class' => 'form-control'))}}
									<span class="red">{{ $errors->first('password_confirmation')}}</span>
								</div>
								<div class="col-lg-6"></div>
							</div>
							
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button class="btn btn-success" type="submit">Change</button> &nbsp;&nbsp;
									@if($data->role_id !=1)
										<a href="{{ URL::to('admin/dashboard/') }}" ><button class="btn btn-default" type="button">Cancel</button></a>
									@endif
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		{{ Form::close() }}
	</div>
</section>
@stop