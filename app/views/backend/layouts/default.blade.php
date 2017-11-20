<?php $url_secure             = Config::get('constants.URL_SECURE'); ?>
<!DOCTYPE html>
<!--
Template Name: Admin Lab Dashboard build with Bootstrap v2.3.1
Template Version: 1.0
Author: Mosaddek Hossain
Website: http://www.mosaddek.com
-->

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
	<title>
		@section('title')
		{{Config::get('constants.USER_ROLES.'.Auth::User()->role_id)}} Dashboard
		@show
	</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">
   
   {{ HTML::style('css/bootstrap.min.css') }}
   {{ HTML::style('css/bootstrap-reset.css') }}
   {{ HTML::style('assets/font-awesome/css/font-awesome.css') }}
   {{ HTML::style('css/style.css') }}
   {{ HTML::style('css/style_responsive.css') }}
   {{ HTML::style('assets/bootstrap-datepicker/css/datepicker.css') }}
   {{ HTML::style('assets/bootstrap-timepicker/compiled/timepicker.css') }}
   {{ HTML::style('css/jquery-ui.min.css') }}
   {{ HTML::style('assets/fancybox/source/jquery.fancybox.css?v=2.1.5') }}
   {{ HTML::style('assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5') }}
   {{ HTML::style('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7') }}
    {{ HTML::style('assets/jquery-multi-select/css/multi-select.css') }}


   {{ HTML::script('js/jquery-1.10.2.min.js') }}
    {{ HTML::script('js/shortcuts.js') }}
   {{ HTML::script('js/jquery-ui.js') }}
    {{ HTML::script('assets/jquery-multi-select/js/jquery.multi-select.js') }}
	 {{ HTML::script('js/bootstrap-switch.js') }}
	  {{ HTML::script('js/Chart.bundle.js') }}
	  
		<script type="text/javascript">
			shortcut.add("Ctrl+D",function() {
				window.location.href = "{{URL::to('admin/dashboard')}}";
			});
			shortcut.add("Ctrl+C",function() {
				window.location.href = "{{URL::to('admin/users/2')}}";
			});
			shortcut.add("Ctrl+B",function() {
				window.location.href = "{{URL::to('admin/users/import_data_list/all')}}";
			});
		</script> 
</head>
<!-- END HEAD -->


<!-- BEGIN BODY -->
<body>
	<section id="container" class="">
		
		@include('backend/layouts/header')
		
		@include('backend/layouts/navigation')
		 
		<section id="main-content">
			@yield('content')
		</section>
		   
		<footer class="site-footer">
			<div class="text-center">
				2016 &copy; {{ Config::get('constants.SITE_TITLE')}} Copyright reserved.
				<a href="#" class="go-top">
					<i class="fa fa-angle-up"></i>
				</a>
			</div>
		</footer>
	</section>

	
	<!--common script for all pages-->
	 {{ HTML::script('js/jquery-migrate-1.2.1.min.js') }}
	  {{ HTML::script('js/bootstrap.min.js') }}
	   {{ HTML::script('js/jquery.dcjqaccordion.2.7.js') }}
	    {{ HTML::script('js/jquery.scrollTo.min.js') }}
		 {{ HTML::script('js/jquery.nicescroll.js') }}
		  {{ HTML::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js') }}
		   {{ HTML::script('assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}
			{{ HTML::script('assets/bootstrap-timepicker/js/bootstrap-timepicker.js') }}
			  {{ HTML::script('js/slidebars.min.js') }}
				{{ HTML::script('js/common-scripts.js') }}
				  {{ HTML::script('assets/fancybox/jquery.mousewheel-3.0.6.pack.js') }}
				   {{ HTML::script('assets/fancybox/source/jquery.fancybox.js?v=2.1.5') }}
					{{ HTML::script('assets/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5') }}
					 {{ HTML::script('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7') }}
					  {{ HTML::script('assets/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6') }}
				  
				  
		<script language="JavaScript"> 
			jQuery(document).ready(function() {
				$(".topnav").accordion({
					accordion:false,
					speed: 500,
					closedSign: '+',
					openedSign: '-'
				});
			 
				jQuery('.fancybox').fancybox();
			}); 
		</script>
</body>
<!-- END BODY -->
</html>