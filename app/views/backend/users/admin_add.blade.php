@extends('backend/layouts/default')

@section('title')
	User Management 
@stop

@section('content')

@include('backend/alert_message')

<section class="wrapper site-min-height">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-title">
				User
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
					<a href="{{ URL::to('admin/users/2') }}">Users</a> 
					<span class="divider">&nbsp;</span>
				</li>
				<li>
					<a href="javascript:;">Add User</a> 
					<span class="divider-last">&nbsp;</span>
				</li>
			</ul>
		</div>
	</div>
	
	@include('Elements/User/top_link')
	
  <!-- page start-->
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<header class="panel-heading">
					Add new User
				</header>
				<div class="panel-body">
					{{ Form::open(array('url' => array('admin/users/add'), 'class' => 'form-horizontal', 'name'=>'User','files' => true)) }}
					
					@include('Elements/User/form')
					
					<div class="row" style="margin-top:20px;">
						<div class="col-lg-6">
							<div class="form-group">
								<div class="col-lg-offset-4 col-lg-8">
									<button class="btn btn-success" type="submit">Save</button> &nbsp;&nbsp;
									<a href="{{ URL::to('admin/users/2') }}" ><button class="btn btn-default" type="button">Cancel</button></a>
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
