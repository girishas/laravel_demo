<?php $url_secure = Config::get('constants.URL_SECURE'); ?>
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
  
 
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="Mosaddek" />
    <meta name="keyword" content="AdminLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina" />
	<link rel="shortcut icon" href="img/favicon.png">
	 <title>{{ Config::get('constants.SITE_TITLE')}} login</title>
	  {{ HTML::style('css/bootstrap.min.css') }}
	   {{ HTML::style('css/bootstrap-reset.css') }}
	    {{ HTML::style('assets/font-awesome/css/font-awesome.css') }}
		 {{ HTML::style('css/style_responsive.css') }}
		  {{ HTML::style('css/style.css') }}
</head>

<body id="login-body">
	<div class="container">
			
			{{ Form::open(array('url' => url('admin/login'), 'class'=>'form-signin', 'id'=>'loginform')) }}
				@if (Session::has('message'))
					<div id="my_msg" class="row">
						<div class="col-lg-12">
							<div class="alert alert-danger fade in" style="margin-bottom:0px;">
								<button class="close close-sm" type="button" data-dismiss="alert">
									<i class="fa fa-times"></i>
								</button>
								{{ Session::get('message') }}
							</div>
						</div>
					</div>
				
				@endif
				
				<h2 class="form-signin-heading" style="background:#007684;padding:20px 5px;"> {{ Config::get('constants.SITE_TITLE')}} </h2>
				 <div class="login-wrap">
					{{ Form::text('email', Input::old('email'), array('class'=>'form-control', 'placeholder'=>'User Name','id'=>'input-username')) }}
					<span class="red">{{ $errors->first('email')}}</span>
					{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password','id'=>'input-password')) }}
					<span class="red">{{ $errors->first('password')}}</span>
					<label class="checkbox">
						<input type="checkbox" value="remember-me"> Remember me
						<span class="pull-right">
							<?php /* <a data-toggle="modal" href="javascript:;" style="color:#5b6e84;"> Forgot Password?</a> */ ?>
						</span>
					</label>
					<input type="submit" id="login-btn" class="btn btn-lg btn-login btn-block" style="background: #007684 none repeat scroll 0 0;box-shadow: 0 4px #0a8f84;" value="Login" />
				</div>	
				{{ Form::close() }}
		</div>


  <!-- BEGIN JAVASCRIPTS -->
  {{ HTML::script('js/jquery.js', array(), $url_secure) }}
  {{ HTML::script('js/bootstrap.min.js', array(), $url_secure) }}
	<script>
	jQuery(document).ready( function() {
		jQuery('.flash-message').delay(3000).fadeOut();
	});
	</script>
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>