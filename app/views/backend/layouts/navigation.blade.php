<?php
	$action 		= (Route::currentRouteAction())?explode('@', Route::currentRouteAction()):'';
	$controller		= (isset($action[0]) and $action[0])?$action[0]:'';
	$current_action = (isset($action[1]) and $action[1])?$action[1]:'';
	
	$role_id = Route::input('role_id'); 
	$logged_in_role_id = Auth::check()?Auth::User()->role_id:2; ?>
<aside>
	<div id="sidebar"  class="nav-collapse">
		<ul class="sidebar-menu" id="nav-accordion"><?php
			$class = ($current_action == 'getDashBoard')?'active':null; ?>
			<li>
				<a  class="{{$class}}" href="{{ URL::to('admin/dashboard') }}">
					<i class="fa fa-dashboard"></i>
					<span>Dashboard</span>
				</a>
			</li><?php 
					
			$class = ((Auth::User()->role_id  == Route::input('role_id') OR Route::input('role_id') =="") and ($current_action == 'admin_change_password' || ($current_action == 'admin_update_profile'))) ?'active':null; ?>
			<li class="sub-menu">
				<a href="javascript:;" class="<?php echo $class; ?>">
					<i class="fa fa-user"></i>
					<span>{{Auth::User()->role_id == 2?'My Profile':'Admin Management'}}</span>
				</a>
				
				<ul class="sub">
					<li class="<?php echo ( $current_action == 'admin_update_profile')?'active':''; ?>"><a  href="{{ URL::to('admin/update_profile') }}">Update Profile</a></li>
					<li class="<?php echo ( $current_action == 'admin_change_password')?'active':''; ?>"><a  href="{{ URL::to('admin/users/change_password/'.Auth::User()->role_id.'/'. Auth::id()) }}">Change Password</a></li>
				</ul>
			</li>
			
			@if(Auth::User()->role_id == 1)
				<?php $class = (($controller =="UserController" && (in_array($current_action, array('admin_add', 'admin_del', 'admin_view', 'admin_edit', 'admin_index'))))   )?'active':null;  ?>
				<li class="sub-menu">
					<a href="javascript:;" class="<?php echo $class; ?>">
						<i class="fa fa-users"></i>
						<span>User Management</span>
					</a>
					
					<ul class="sub">
						<li class="<?php echo in_array($current_action, array('admin_view', 'admin_index', 'admin_change_password', 'admin_edit'))?'active':''; ?>"><a  href="{{ URL::to('admin/users/2') }}">Users List &nbsp;<span class="badge bg-primary">{{GeneralHelper::getClientdataCount(0)}}</span></a></li>
						<li class="<?php echo ($current_action == 'admin_add')?'active':''; ?>"><a  href="{{ URL::to('admin/users/add') }}">Add a User</a></li>
					 </ul>
				</li>
				
				<?php
					 
					$class = (($controller =="TrackableController" && (in_array($current_action, array('admin_del', 'admin_view', 'admin_edit','admin_add', 'admin_index'))))  )?'active':null;  ?>
				<li class="sub-menu">
					<a href="javascript:;" class="<?php echo $class; ?>">
						<i class="fa fa-users"></i>
						<span>Trackable Management</span>
					</a>
					
					<ul class="sub">
						<li class="<?php echo in_array($current_action, array('admin_view', 'admin_index', 'admin_edit'))?'active':''; ?>"><a  href="{{ URL::to('admin/trackables') }}">Trackable List &nbsp;<span class="badge bg-primary">{{GeneralHelper::getTrackabledataCount(0)}}</span></a></li>
						<li class="<?php echo ($current_action == 'admin_add')?'active':''; ?>"><a  href="{{ URL::to('admin/trackables/add') }}">Add a Trackable</a></li>
					 </ul>
				</li>
			@endif	
			<li>
				<a class="" href="{{ URL::to('admin/logout') }}">
				<span class="icon-box"><i class="fa fa-power-off"></i></span> Logout</a>
			</li>
		</ul>
	</div>
</aside> 