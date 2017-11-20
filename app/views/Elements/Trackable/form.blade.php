<?php 
$oldrole_id = (Input::old('role_id')); 
$status = Config::get('constants.STATUS');
$is_mandatory = Config::get('constants.OPTIONS');
?>
<div class="row">
	<div class="col-lg-6">
		<div class="form-group">{{ Form::hidden('author_id', Auth::id()) }}
			<label for="role_id" class="control-label col-lg-4 right"> Name<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::text('name', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('name')}}</span>
			</div>
		</div>	
	</div>
	
	<div class="col-lg-6">
		<div class="form-group">
			<label for="role_id" class="control-label col-lg-4 right"> Unit<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::text('unit', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('unit')}}</span>
			</div>
		</div>	
	</div>
	
	<div class="col-lg-6">
		<div class="form-group">
			<label for="role_id" class="control-label col-lg-4 right"> Alert<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				<!--{{ Form::text('alert', null, array('class' => 'form-control'))}}-->
				{{ Form::textarea('alert', null, array('rows'=>2,'class' => 'form-control')) }}
				<span class="red">{{ $errors->first('alert')}}</span>
			</div>
		</div>	
	</div>
	
	<div class="col-lg-6">
		<div class="form-group">
			<label class="control-label col-md-4">Alert Frequence</label>
			<div class="col-md-8">
				<div class="input-group bootstrap-timepicker">
					{{ Form::text('alert_frequence', null, array('class' => 'form-control timepicker-24'))}}
					<span class="input-group-btn">
						<button class="btn btn-default red" type="button"><i class="fa fa-clock-o"></i></button>
						{{ $errors->first('alert_frequence')}}
					</span>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-6">
		<div class="form-group">
			<label for="role_id" class="control-label col-lg-4 right">Logic If GreaterThan<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::text('logic_if_greaterthen', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('logic_if_greaterthen')}}</span>
			</div>
		</div>	
	</div>
	
	<div class="col-lg-6">
		<div class="form-group">
			<label for="role_id" class="control-label col-lg-4 right">Cancer Killer X<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::text('cancer_killer_x', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('cancer_killer_x')}}</span>
			</div>
		</div>	
	</div>
	
	<div class="col-lg-6">
		<div class="form-group">
			<label for="role_id" class="control-label col-lg-4 right">Happy Heart X<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::text('happy_heart_x', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('happy_heart_x')}}</span>
			</div>
		</div>	
	</div>
	
	<div class="col-lg-6">
		<div class="form-group">
			<label for="role_id" class="control-label col-lg-4 right">Weight Control X<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::text('weight_control_x', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('weight_control_x')}}</span>
			</div>
		</div>	
	</div>
	
	<div class="col-lg-6">
		<div class="form-group">
			<label for="role_id" class="control-label col-lg-4 right">Mood Meter X<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::text('mood_meter_x', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('mood_meter_x')}}</span>
			</div>
		</div>	
	</div>
	
	<div class="col-lg-6">
		<div class="form-group">
			<label for="role_id" class="control-label col-lg-4 right">Options<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::select('is_mandatory',$is_mandatory, null, array('class' => 'form-control'))}}
			</div>
		</div>	
	</div>
	
	
	<div class="col-lg-6">
		<div class="form-group">
			<label for="image" class="control-label col-lg-4 right">Image </label>
			<div class="col-lg-8">
				{{ Form::file('image', array('id' => 'image', 'class' => 'form-control')) }}
				<small class="green">*(Allowed Format: JPEG,jpg,png,gif)</small><br />
				<span class="red">{{ $errors->first('image')}}</span>
			</div>
			
		</div>
		@if(Route::currentRouteName() == 'admin_update_profile')
			@if($Trackable->image != "" and file_exists('upload/trackable/large/'.$Trackable->image))
				<div class="form-group">
					<label for="image" class="control-label col-lg-4 right">&nbsp; </label>
					<div class="col-lg-8">
						{{GeneralHelper::showTrackableImg($Trackable->image,'','75px','',$Trackable->name,'thumb')}}
					</div>
				</div>
			@endif
		@endif
		 
	 
		<div class="form-group">
			<label for="status" class="control-label col-lg-4 right">Status </label>
			<div class="col-lg-8">
				{{ Form::select('status',$status, null, array('class' => 'form-control'))}}
			</div>
		</div>		
	</div> 
 
 
			</div>																		
