@extends('backend/layouts/default')
<?php
	$role_id = Route::input('role_id');
	$data_role =  Config::get('constants.USER_ROLES.'.$role_id); 
	$data_role  = str_plural($data_role);
?>

@section('title')
	User Management
@stop

@section('content')


@include('backend/alert_message')


<section class="wrapper site-min-height">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-title">
			{{ Config::get('constants.USER_ROLES.'.Auth::User()->role_id) }}
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
					<a href="{{ URL::to('admin/users/'.$role_id) }}">Users </a> 
					<span class="divider">&nbsp;</span>
				</li>
				<li>
					<a href="javascript:;">{{ 'Update :'.$data->name }}</a> 
					<span class="divider-last">&nbsp;</span>
				</li>
			</ul>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<header class="panel-heading">
					Update : {{ $data->name }}
				</header>
				<div class="panel-body">
					{{ Form::model($data,array('url' => array('admin/users/edit', $data->role_id, $data->id),'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true)) }}
					
					@include('Elements/User/form')
					
					<div class="row" style="margin-top:20px;">
						<div class="col-lg-6">
							<div class="form-group">
								<div class="col-lg-offset-4 col-lg-8">
									<button class="btn btn-success" type="submit">Update</button> &nbsp;&nbsp;
									<a href="{{ URL::to('admin/users/'.$role_id) }}" class="btn btn-default" >Cancel</a>
								</div>
							</div>
						</div>
						<div class="col-lg-6"></div>
					</div>
					{{ Form::close() }}
				</div>
			</section>
		</div>
	</div>
</section>


<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery( ".datepicker" ).datepicker({
			format: 'yyyy-mm-dd'
		});
	});
</script>
@stop