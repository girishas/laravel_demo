@extends('backend/layouts/default')

@section('title')
	A/R Management 
@stop

@section('content')

@include('backend/alert_message')

<section class="wrapper site-min-height">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-title">
				Import Data
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
					<a href="javascript:;">Import Data</a> 
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
					Import Data
				</header>
				<div class="panel-body">
					{{ Form::open(array('url' => array('admin/users/import_data'), 'class' => 'form-horizontal', 'name'=>'User','files' => true)) }}
					
					<div class="row">
						<div class="col-lg-7">
							<div class="form-group {{$errors->first('user_id')?'has-error':''}}">
								<label for="role_id" class="control-label col-lg-4"> Name<span class='red bold'>*</span></label>
								<div class="col-lg-8">
									{{ Form::hidden('user_id',null,array('id'=>'CompanyId'))}}
									{{ Form::text('user_name', null, array('class' => 'form-control',  'id'=> 'selectUser'))}}
									<small class="info">Type User's name/email and select user from suggention box.</small>
									<span class="help-block"> {{$errors->first('user_id')}} </span>
								</div>
							</div>
							
							<div class="form-group {{$errors->first('import_data')?'has-error':''}}">
								<label for="photo" class="control-label col-lg-4">{{ 'Excel File' }} </label>
								<div class="col-lg-8">
									{{ Form::file('import_data', array('class' => 'form-control')) }}
									<span class="help-block">{{ $errors->first('import_data')}}</span>
								</div>
							</div>
							<?php /*
							<div class="form-group">
								<label for="photo" class="control-label col-lg-4">&nbsp;</label>
								<div class="col-lg-8">
									NOTE: 
								When you upload file, our system will read starting 3 letters of file name and identify file xls format (PPI.. , CED from cedars, LPW or LPE.. ). System will manipulate file on the base on that and import data.. so please add these letter starting file name before you go for import xls.

								CED or Starting by cedars file need in CSV format. Other two will be in xls format.

								</div>
							</div> */ ?>
							
							<div class="form-group">
								<div class="col-lg-offset-4 col-lg-8">
									<button class="btn btn-success" type="submit">Save</button> &nbsp;&nbsp;
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
	});
</script>
	
@stop
