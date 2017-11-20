@extends('backend/layouts/default')

@section('title')
	A/R Management 
@stop

@section('content')

@include('backend/alert_message')

@if (Session::has('message'))
    <div class="flash-message success-msg">{{ Session::get('message') }}</div>
@endif
<section class="wrapper site-min-height">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-title">
				Export Data
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
					<a href="javascript:;">Export Data</a> 
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
					Export Data
				</header>
				<div class="panel-body">
					{{ Form::open(array('url' => array('admin/users/export_data'), 'class' => 'form-horizontal', 'name'=>'User','files' => true)) }}
					
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group {{$errors->first('user_id')?'has-error':''}}">
								<label class="control-label col-lg-3"> Name<span class='red bold'>*</span></label>
								<div class="col-lg-9">
									{{ Form::hidden('user_id',null,array('id'=>'CompanyId'))}}
									{{ Form::text('user_name', null, array('class' => 'form-control',  'id'=> 'selectUser'))}}
									<small class="info">Type User's name/email and select user from suggention box.</small>
									<span class="help-block"> {{$errors->first('user_id')}} </span>
								</div>
							</div>
							
							<div class="form-group {{$errors->first('date_from')?'has-error':''}}">
								<label class="control-label col-lg-3"> Date Range</label>
								<div class="col-lg-4">
									{{ Form::text('date_from', null, array('class' => 'form-control datepicker'))}}
									<span class="help-block"> {{$errors->first('date_from')}} </span>
								</div>
								<label class="control-label col-lg-1"> To</label>
								<div class="col-lg-4">
									{{ Form::text('date_to', null, array('class' => 'form-control datepicker1'))}}
									<span class="help-block"> {{$errors->first('date_to')}} </span>
								</div>
								<small class="col-lg-offset-3 col-lg-9 info">Without date range system will download complete user data.
								 </small>
							</div>
							 
							<div class="form-group">
								<div class="col-lg-offset-3 col-lg-9">
									<button class="btn btn-success" type="submit">Export</button> &nbsp;&nbsp;
									<a href="{{ URL::to('admin/users/import_data_list/all') }}" ><button class="btn btn-default" type="button">Cancel</button></a>
								</div>
							</div>
						</div>
					</div>
					{{ Form::close() }}
					</div>
			</section>
		</div>
	</div>
</section>
<script type="text/javascript">
	jQuery(document).ready(function(){
		 jQuery('#selectUser').autocomplete({
			source:"{{ URL::to('admin/users/select_user') }}", 
			minLength:1,
			select:function(evt, ui){
				this.form.CompanyId.value	= ui.item.user_id;
			}
		});
		jQuery('.datepicker').datepicker({
			format : 'yyyy-mm-dd'
		});
		jQuery('.datepicker1').datepicker({
			format : 'yyyy-mm-dd'
		});
	});
</script>
	
@stop
