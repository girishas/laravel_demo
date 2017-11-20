<?php $logged_in_role_id = Auth::check()?Auth::User()->role_id:2; ?>
<header class="header white-bg">
  <div class="sidebar-toggle-box">
	  <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
  </div>
   <!--logo start-->
	<a href="{{ URL::to('admin/dashboard') }}" class="logo" style="font-size:20px;margin-top:10px;" >		
		<span style="font-size: 24px;color: #179ee3;float: left;">{{ Config::get('constants.SITE_TITLE')}}</span>
	</a>
	@if(Auth::check() and Auth::user()->role_id == 1) <?php
		
		$notifications   = GeneralHelper::getNotesNotifications(); ?>
		
		<?php /* <div class="nav notify-row" id="top_menu">
			<ul class="nav top-menu">
				<li id="header_notification_bar" class="dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<i class="fa fa-bell-o"></i>
						<span class="badge bg-warning">{{count($notifications)}}</span>
					</a>
					<ul class="dropdown-menu extended notification">
						<div class="notify-arrow notify-arrow-yellow"></div>
						<li>
							<p class="yellow">You have {{count($notifications)}} notes notifications</p>
						</li>
						
						@foreach($notifications as $notification)
							<li>
								<a href="#">
									Notes for AR Account {{$notification->name}} updated.
									<span class="small italic">{{date('F d, Y', strtotime($notification->updated_at))}}</span>
								</a>
							</li>
						@endforeach
					</ul>
				</li>
			</ul>
		</div> */ ?>
	@endif

	<div class="top-nav ">
		<ul class="nav pull-right top-menu"> 
		  <!-- user login dropdown start-->
			<li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">
					{{ GeneralHelper::showUserImg(Auth::user()->photo, '', '30px', '30px',Auth::user()->name,'' ) }} 
					<span class="username"><?php echo $email = Auth::user()->name; ?></span>
					<b class="caret"></b>
				</a>
				<ul class="dropdown-menu extended logout">
					<div class="log-arrow-up"></div>
					<li><a href="{{ URL::to('admin/update_profile') }}"><i class=" fa fa-suitcase"></i>Profile</a></li>
					<li><a href="{{ URL::to('admin/users/change_password/'.$logged_in_role_id.'/'.Auth::id()) }}"><i class="fa fa-key"></i> Change Password</a></li>
					<li style ="background-color:#179ee3;"><a href="{{ URL::to('admin/logout') }}"><i class="fa fa-power-off"></i> Log Out</a></li>
				</ul>
			</li>
		</ul>
	</div>
</header> 