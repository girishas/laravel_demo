<?php 
	
	$current_action 		= (Route::currentRouteAction())?explode('@', Route::currentRouteAction()):'';
	$controller				= (isset($current_action[0]) and $current_action[0])?$current_action[0]:'';
	$action 				= (isset($current_action[1]) and $current_action[1])?$current_action[1]:'';  
	$next_step              = (Session::has('register.next_step') && Session::get('register.next_step'))?Session::get('register.next_step'):1;  ?>

	<div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills nav-justified thumbnail setup-panel"> <?php 
				$stepClass = ($controller == 'UserController' and $action == 'register_step1')?'step-active':'normal'; ?>
				
                <li class="{{$stepClass}}">
					<a href="{{URL::to('register/step1')}}">
						<h4 class="list-group-item-heading">Step 1</h4>
						<p class="list-group-item-text">Choose Template Below</p>
					</a>
				</li><?php 
				
				$stepClass = ($controller == 'UserController' and ($action == 'register_step2' OR $action == 'register_step2_preview' OR $action == 'register_img_crop_to_file'))?'step-active':(($next_step < 2)?'disabled':'normal'); ?>
                <li class="{{$stepClass}}">
					<a href="{{URL::to('register/step2')}}">
						<h4 class="list-group-item-heading">Step 2</h4>
						<p class="list-group-item-text">Personal Info & Preview</p>
					</a>
				</li><?php 
				
				$stepClass = ($controller == 'UserController' and ($action == 'register_step3' OR $action == 'register_step3_preview'))?'step-active':(($next_step < 4)?'disabled':'normal'); ?>
               <li class="{{$stepClass}}">
					<a href="{{URL::to('register/step3')}}">
						<h4 class="list-group-item-heading">Step 3</h4>
						<p class="list-group-item-text">Add Smart Links & Preview</p>
					</a>
				</li> 
				
				@if(!(Session::has('update_card_id') && Session::get('update_card_id'))) <?php 
					$stepClass = ($controller == 'UserController' and ($action == 'register_step4' OR $action == 'register_step4_choose_plan'))?'step-active':(($next_step < 6)?'disabled':'normal'); ?>
					<li class="{{$stepClass}}">
						<a href="{{URL::to('register/step4/choose-plan')}}">
							<h4 class="list-group-item-heading">Step 4</h4>
							<p class="list-group-item-text">Plans & Payments</p>
						</a>
					</li><?php 
					
					$stepClass = ($controller == 'UserController' and $action == 'register_step5')?'step-active':'disabled'; ?>
					<li class="{{$stepClass}}">
						<a href="{{URL::to('register/step5')}}">
							<h4 class="list-group-item-heading">Step 5</h4>
							<p class="list-group-item-text">Thank You</p>
						</a>
					</li>
				@endif
            </ul>
        </div>
	</div>
	
		
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('.disabled').click(function() { 
				return false; 
			});
		});
	</script>