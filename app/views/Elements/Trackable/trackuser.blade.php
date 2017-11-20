<?php 
$oldrole_id = (Input::old('role_id')); ?>
<div class="row">	
	<div class="form-group">
		<label class="control-label col-md-3">select Users</label>
		<div class="col-md-9">
			<select multiple="multiple" class="multi-select" id="my_multi_select1" name="my_multi_select1[]">
				@if($users)
					@foreach ($users as $k => $val) 									
					  <option value="{{ $k }}">{{ $val }}</option>
					@endforeach
				@endif
			</select>
		</div>
	</div>
</div>																		
