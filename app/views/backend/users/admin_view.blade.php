@extends('backend/layouts/default')
<?php
	$role_id = Route::input('role_id');
	$data_role =  Config::get('constants.USER_ROLES.'.$role_id); 
	$data_role  = str_plural($data_role); 
?>

@section('title')
{{$data_role}} Management 
@stop

@section('content')
@include('backend/alert_message')



<section class="wrapper site-min-height">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-title">
				{{$data_role}}
			</h3>
			<ul class="breadcrumb-new">
				<li>
					<a href="{{ URL::to('admin') }}">
						<i class="fa fa-home"></i>
					</a>
					<span class="divider">&nbsp;</span>
				</li>
				
				<li>
					<a href="{{ URL::to('admin') }}">Dashboard</a> <span class="divider">&nbsp;</span>
				</li>
				
				<li>
					<a href="{{ URL::to('admin/users/'.$role_id) }}">{{$data_role}}</a> 
					<span class="divider">&nbsp;</span>
				</li>
				
				<li>
					<a href="javascript:;">{{'Detail of : ' .$user->name }}</a> 
					<span class="divider-last">&nbsp;</span>
				</li>
				
			</ul>
		</div>
	</div>
	
	@include('Elements/User/top_link')
	
	<div class="row">
		<div class="col-lg-12">
			<section class="panel"> 
				<header class="panel-heading">
					Detail of : {{$user->name}}
				</header>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							
							<h4>{{ $user->name }}</h4>							 
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Photo</b></div>
								<div class="col-lg-8">{{ GeneralHelper::showUserImg($user->photo, '', '48%', '',$user->name,'thumb') }}  </div>
							</div><br/>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Email</b></div>
								<div class="col-lg-8">: {{ $user->email }} </div>
							</div>						
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Address</b></div>
								<div class="col-lg-8">: {{ $user->street_1}} </div>
							</div>							
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Description</b></div>
								<div class="col-lg-8">: {{ $user->description!=''?$user->description:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>City</b></div>
								<div class="col-lg-8">: {{ $user->city!=''?$user->city:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Zip Code</b></div>
								<div class="col-lg-8">: {{ $user->zip!=''?$user->zip:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>State</b></div>
								<div class="col-lg-8">: {{ $user->state!=''?$user->state:'----' }} </div>
							</div>
							 
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Mobile</b></div>
								<div class="col-lg-8">: {{ $user->mobile!=''?$user->mobile:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Status</b></div>
								<div class="col-lg-8">: {{ Config::get('constants.STATUS.'.$user->status) }} </div>
							</div>
							 
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Registered On</b></div>
								<div class="col-lg-8">: {{ date('F d,Y', strtotime($user->created_at)) }} </div>
							</div>
							
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Updated On</b></div>
								<div class="col-lg-8">: {{ date('F d,Y', strtotime($user->updated_at)) }} </div>
							</div>
						</div>
					</div>
					<div class="row panel-spacing" style="margin-top:30px;" >
						<div class="col-lg-12"><a class="btn btn-default" href="{{ URL::to('admin/users/'.$role_id)}}" ><i class='fa fa-reply'> Back</i></a></div>
					</div>
				</div>
			</section>
		</div>
	</div>
</section>
@stop																													