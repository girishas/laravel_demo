<?php 
$user_id 		= Route::input('user_id');$action 		= (Route::currentRouteAction())?explode('@', Route::currentRouteAction()):'';$controller		= (isset($action[0]) and $action[0])?$action[0]:'';$current_action = (isset($action[1]) and $action[1])?$action[1]:''; 
$role_id = Route::input('role_id');
$new_reg = Route::input('new_reg');
if($new_reg!=1) {	$URL = URL::current(); ?>
	@if(!empty($role_id))
	<div class="row {{ ($current_action != 'admin_index')?' marginBtm25':'' }}">
		<div class="col-lg-12">
			<a href="{{ URL::to('admin/users/2') }}" style="{{ (($role_id == 2) && ($current_action == 'admin_index' || $current_action == 'admin_edit' || $current_action == 'admin_view'))?'display:none':'' }}" class="btn btn-info marginbottom5"><i class="fa fa-users "></i>&nbsp;{{Config::get('constants.USER_ROLES.'.$role_id)}}</a>			
			<a href="{{ URL::to('admin/users/3') }}" style="{{ (($role_id == 3) && ($current_action == 'admin_index' || $current_action == 'admin_edit' || $current_action == 'admin_view'))?'display:none':'' }}" class="btn btn-info marginbottom5"><i class="fa fa-th-large"></i>&nbsp;{{Config::get('constants.USER_ROLES.'.$role_id)}}</a>			
			<a href="{{ URL::to('admin/users/add') }}" style="{{ ($controller =='UserController' && $current_action == 'admin_add')?'display:none':'' }}" class="btn btn-info marginbottom5"><i class="fa fa-user-plus"></i>&nbsp;Create User </a>
			
			@if($user_id)
			<?php $user = User::find($user_id);  ?>				
			<a href="{{ URL::to('admin/users/edit/'.$role_id.'/'.$user_id) }}" style="{{ ($controller =='UserController' && $current_action == 'admin_edit')?'display:none':'' }}" class="btn btn-info marginbottom5" ><i class="fa fa-edit"></i>&nbsp;Update {{Config::get('constants.USER_ROLES.'.$role_id)}}</a>				
			<a href="{{ URL::to('admin/users/view/'.$role_id.'/'.$user_id) }}"  style="{{ ($controller =='UserController' && $current_action == 'admin_view')?'display:none':'' }}" class="btn btn-info marginbottom5"><i class="fa fa-eye"></i>&nbsp;View Details</a>				
			<a href="{{ URL::to('admin/users/change_password/'.$user->role_id.'/'.$user_id) }}"  style="{{ ($controller =='UserController' && $current_action == 'admin_change_password')?'display:none':'' }}" class="btn btn-info marginbottom5"><i class="fa fa-key"></i>&nbsp; Change Password</a>&nbsp;			
			@endif
		</div>
	</div>
	@endif <?php 
} ?>