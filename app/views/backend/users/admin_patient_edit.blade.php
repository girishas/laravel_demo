@extends('backend/layouts/default')
@section('title')
Update A/R data
@stop

@section('content')
<?php  $user_id = Route::input('user_id') ;?> 
@include('backend/alert_message')

<section class="wrapper site-min-height">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-title">
			Update A/R Data : {{$patient->name}}
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
					<a href="{{ URL::to('admin/users/import_data_list/'.Route::input('user_id')) }}"> Imported A/R data List </a> 
					<span class="divider">&nbsp;</span>
				</li>
				<li>
					<a href="javascript:;">Update A/R Data : {{$patient->name}}</a> 
					<span class="divider-last">&nbsp;</span>
				</li>
			</ul>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<header class="panel-heading">
					Update Patient Data : {{$patient->name}}
				</header>
				<div class="panel-body">
					{{ Form::model($patient,array('url' => array('admin/imported_data/edit', Route::input('user_id'), $patient->id),'method' => 'PUT', 'class' => 'form-horizontal')) }}
					
					@include('Elements/User/form_patient')
					
					<div class="row" style="margin-top:20px;">
						<div class="col-lg-6">
							<div class="form-group">
								<div class="col-lg-offset-4 col-lg-8">
									<button class="btn btn-success" type="submit">Update</button> &nbsp;&nbsp;
									<a href="{{ URL::to('admin/users/import_data_list/'.Route::input('user_id')) }}" class="btn btn-default" >Cancel</a>
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