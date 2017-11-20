<?php 
$oldrole_id = (Input::old('role_id')); 
$status = Config::get('constants.STATUS');
?>
<div class="row">
	<div class="col-lg-6">
		<div class="form-group">
			<label for="role_id" class="control-label col-lg-4"> Name<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::text('name', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('name')}}</span>
			</div>
		</div>
		
		<div class="form-group">
			<label for="username" class="control-label col-lg-4">Email <span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::text('email', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('email')}}</span>
			</div>
		</div>
		
		@if(Route::currentRouteName() == 'users.admin_add')
		<div class="form-group">
			<label for="password" class="control-label col-lg-4">Password<span class='red bold'>*</span></label>
			<div class="col-lg-8">
				{{ Form::password('password',  array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('password')}}</span>
			</div>
		</div>
		@endif
		
		
		<div class="form-group" id="locationField">
			<label for="nnnn" class="control-label col-lg-4">Address</label>
			<div class="col-lg-8">
				{{ Form::text('nnnn', isset($data->street_1)?$data->street_1:null, array('id'=>"autocomplete", "placeholder" =>"Enter a location to autocomplete", "onFocus"=>"geolocate()", 'class' => 'form-control'))}}
				<span class="red">{{ $errors->first('nnnn')}}</span>
			</div>
		</div>
		
		<div class="form-group hide">
			<label for="street_1" class="control-label col-lg-4">Address</label>
			<div class="col-lg-8">
				{{ Form::text('street_1', null, array('id'=>"street_number", 'class' => 'form-control')) }}
				<span class="red">{{ $errors->first('street_1')}}</span>
			</div>
		</div>
		
		<div class="form-group">
			<label for="city" class="control-label col-lg-4">City</label>
			<div class="col-lg-8">
				{{ Form::text('city', null, array('id'=>"locality", 'class' => 'form-control'))}}
				<span class="red">{{ $errors->first('city')}}</span>
			</div>
		</div>
		<div class="form-group">
			<label for="zip" class="control-label col-lg-4">Zip / Postal Code</label>
			<div class="col-lg-8">
				{{ Form::text('zip', null, array('id'=>"postal_code", 'class' => 'form-control'))}}
			</div>
		</div>
		
		<div class="form-group">
			<label for="username" class="control-label col-lg-4">State</label>
			<div class="col-lg-8">
				{{ Form::text('state', null, array('id'=>"administrative_area_level_1", 'class' => 'form-control'))}}
			</div>
		</div>
		
	
	</div>
	
	
	<div class="col-lg-6">
		
		<div class="form-group">
			<label for="photo" class="control-label col-lg-4">Image </label>
			<div class="col-lg-8">
				{{ Form::file('photo', array('id' => 'photo', 'class' => 'form-control')) }}
				<small class="green">*(Allowed Format: JPEG,jpg,png,gif)</small><br />
				<span class="red">{{ $errors->first('photo')}}</span>
			</div>
			
		</div>
		@if(Route::currentRouteName() == 'admin_update_profile')
			@if($data->photo != "" and file_exists('upload/users/profile-photo/large/'.$data->photo))
				<div class="form-group">
					<label for="photo" class="control-label col-lg-4">&nbsp; </label>
					<div class="col-lg-8">
						{{GeneralHelper::showUserImg($data->photo,'','75px','',$data->name,'thumb')}}
					</div>
				</div>
			@endif
		@endif
		<div class="form-group">
			<label for="mobile" class="control-label col-lg-4">Mobile</label>
			<div class="col-lg-8">
				{{ Form::text('mobile', null, array('class' => 'form-control'))}}
				<span class="red">{{ $errors->first('mobile')}}</span>
			</div>
		</div>
		@if(Route::currentRouteName() != 'admin_update_profile')
		<div class="form-group">
			<label for="status" class="control-label col-lg-4">Status </label>
			<div class="col-lg-8">
				{{ Form::select('status',$status, null, array('class' => 'form-control'))}}
			</div>
		</div>
		@endif
		<div class="form-group">
			<label for="description" class="control-label col-lg-4">Description</label>
			<div class="col-lg-8">
				{{ Form::textarea('description', null, array('rows'=>3, 'id' => 'description', 'class' => 'form-control')) }}
				<span class="red">{{ $errors->first('description') }} </span>
			</div>
		</div>
		
	</div>
	
		

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDumE1Fy4cgmTd5Wu19RTL9uiW1pYDANhw&libraries=places&callback=initAutocomplete" async defer></script>

	<script type="text/javascript">
			 // This example displays an address form, using the autocomplete feature
		  // of the Google Places API to help users fill in the information.

		  // This example requires the Places library. Include the libraries=places
		  // parameter when you first load the API. For example:
		  // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

		  var placeSearch, autocomplete;
		  var componentForm = {
			street_number: 'long_name',
			premise: 'long_name', 
			route: 'long_name', 
			sublocality_level_1: 'long_name', 
			sublocality_level_2: 'long_name', 
			locality: 'long_name',
			administrative_area_level_1: 'long_name',
			country: 'short_name',
			postal_code: 'long_name'
		  };
			
		
		function initAutocomplete() {
			// Create the autocomplete object, restricting the search to geographical
			// location types.
			autocomplete = new google.maps.places.Autocomplete(
				/** @type {!HTMLInputElement} */
				(document.getElementById('autocomplete')),
				{types: ['geocode']});

			// When the user selects an address from the dropdown, populate the address
			// fields in the form.
			autocomplete.addListener('place_changed', fillInAddress);
		}

		function fillInAddress() {
		
			jQuery('#street_number').val("");
			jQuery('#locality').val("");
			jQuery('#country').val("");
			jQuery('#postal_code').val("");
			jQuery('#administrative_area_level_1').val("");
			// Get the place details from the autocomplete object.
			var place = autocomplete.getPlace();
			console.log(place);
		   /* for (var component in componentForm) {
			  document.getElementById(component).value = '';
			  document.getElementById(component).disabled = false;
			} */

			// Get each component of the address from the place details
			// and fill the corresponding field on the form.
			//alert(place.address_components.length);
			var st_address ="";
			var city_add ="";
			for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				
				if (componentForm[addressType]) {
					var val = place.address_components[i][componentForm[addressType]];
					if(addressType == 'premise' ||  addressType == 'route' ||  addressType == 'sublocality_level_1' ||  addressType == 'sublocality_level_2'){
						if(st_address == ""){
							st_address  = val;
						}else{
							st_address  += ", "+val;
						}
					}else if(addressType == 'locality'){
						if(city_add == ""){
							city_add  = val;
						}else{
							city_add  += ", "+val;
						}
					}else if(addressType == 'postal_code' || addressType == 'administrative_area_level_1'){
						document.getElementById(addressType).value = val;
					}
					//document.getElementById(addressType).value = val;
				}
			}
			jQuery('#street_number').val(st_address);
			jQuery('#locality').val(city_add);
		}

		  // Bias the autocomplete object to the user's geographical location,
		  // as supplied by the browser's 'navigator.geolocation' object.
		function geolocate() {
			if (navigator.geolocation) {
			  navigator.geolocation.getCurrentPosition(function(position) {
				var geolocation = {
				  lat: position.coords.latitude,
				  lng: position.coords.longitude
				};
				var circle = new google.maps.Circle({
				  center: geolocation,
				  radius: position.coords.accuracy
				});
				autocomplete.setBounds(circle.getBounds());
			  });
			}
		}
 
		
	</script>
	
	
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