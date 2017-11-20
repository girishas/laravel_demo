<?php 
$oldrole_id = (Input::old('role_id')); ?>
<div class="row">
	<div class="col-lg-6">
		<div class="form-group">
			<label for="name" class="control-label col-lg-4"> Name<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::text('name', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('name')}}</span>
			</div>
		</div>
		
		<div class="form-group">
			<label for="insurance_id" class="control-label col-lg-4">Insurance ID<span class='red bold'></span></label>
			<div class="col-lg-8">
				{{ Form::text('insurance_id', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('insurance_id')}}</span>
			</div>
		</div>
		
		<div class="form-group">
			<label for="insurance_company" class="control-label col-lg-4">Insurance Company</label>
			<div class="col-lg-8">
				{{ Form::text('insurance_company', null, array('class' => 'form-control')) }}
				<span class="red">{{ $errors->first('insurance_company')}}</span>
			</div>
		</div>
		
		
		
		<div class="form-group">
			<label for="code" class="control-label col-lg-4">Code<span class='red bold'></span></label>
			<div class="col-lg-8">
				{{ Form::text('code', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('code')}}</span>
			</div>
		</div>
		<div class="form-group">
			<label for="date_from" class="control-label col-lg-4">Date from</label>
			<div class="col-lg-8">
				{{ Form::text('date_from', null, array('class' => 'form-control datepicker'))}}
			</div>
		</div>
		
		<div class="form-group">
			<label for="date_from" class="control-label col-lg-4">Date to</label>
			<div class="col-lg-8">
				{{ Form::text('date_to', null, array('class' => 'form-control datepicker'))}}
			</div>
		</div>
	</div>
	
	
	<div class="col-lg-6">
	
		<div class="form-group">
			<label for="billed_amount" class="control-label col-lg-4">Billed Amount</label>
			<div class="col-lg-8">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					{{ Form::text('billed_amount', null, array('class' => 'form-control'))}}
				</div>
				<span class="red">{{ $errors->first('billed_amount')}}</span>
			</div>
		</div>
		<div class="form-group">
			<label for="paid_amount" class="control-label col-lg-4">Paid Amount</label>
			<div class="col-lg-8">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					{{ Form::text('paid_amount', null, array('class' => 'form-control'))}}
				</div>
				<span class="red">{{ $errors->first('paid_amount')}}</span>
			</div>
		</div>
		<div class="form-group">
			<label for="AR_amount" class="control-label col-lg-4">AR Amount</label>
			<div class="col-lg-8">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					{{ Form::text('AR_amount', null, array('class' => 'form-control'))}}
				</div>
				<span class="red">{{ $errors->first('AR_amount')}}</span>
			</div>
		</div>
		<div class="form-group">
			<label for="status" class="control-label col-lg-4">Status<span class='red bold'></span></label>
			<div class="col-lg-8">
			{{Form::select('status', ['' => 'Select status','Assistance' => 'Assistance', 'Processing' => 'Processing', 'Paid' => 'Paid'], null, ['class' => 'form-control'])}}
			  
			   
				<span class="red">{{ $errors->first('status')}}</span>
			</div>
		</div>
		<?php
	
		$notes= $patient->notes . " [".date('M d,Y')." ] " ;
			
			
			?>
		<div class="form-group">
			<label for="notes" class="control-label col-lg-4">Notes</label>
			<div class="col-lg-8">
				{{ Form::textarea('notes', $notes, array('style' => 'resize:none;', 'rows'=>3, 'class' => 'form-control'))}}
			</div>
		</div>
		
	</div>
	
	
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#user_role').change( function() { ;
				if($('#user_role').val()==2) {
					$('.is_allow_seller').show();
					} else {
					$('.is_allow_seller').hide();
				}
				});
			});
			</script>
			</div>																		