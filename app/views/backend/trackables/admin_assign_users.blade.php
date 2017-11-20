@extends('backend/layouts/default')

@section('title')
	Trackable Management
@parent

@stop


@section('content')

<?php $trackable_id = Route::input('id');?>

@if (Session::has('message'))
    <div class="flash-message success-msg">{{ Session::get('message') }}</div>
@endif

<section class="wrapper site-min-height">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-title">
				Trackable
			</h3>
			<ul class="breadcrumb-new">
				<li>
					<a href="{{ URL::to('admin') }}">
						<i class="fa fa-home"></i>
					</a>
					<span class="divider">&nbsp;</span>
				</li>
				
				<li>
					<a href="{{ URL::to('admin') }}">Dashboard</a> <span class="divider">&nbsp;</span>
				</li>
				
				<li>
					<a href="{{URL::to('admin/trackables')}}">Trackables</a> 
					<span class="divider-last">&nbsp;</span>
				</li>
				
			</ul>
		</div>
	</div>
	
	<section class="panel">
		<header class="panel-heading">
			
		</header>
		<!-- BEGIN PAGE HEADER-->
		
		<div class="panel-body">
			<section id="unseen" class="panel">
					{{ Form::open(array('url' => array('admin/trackables/assign_users/'.$trackable_id), 'class' => 'cmxform form-horizontal tasi-form')) }}
					
					<div class="form-group">
						<label class="control-label col-md-3">select Users</label>
						<div class="col-md-9">
						<?php $old_links = Input::old('my_multi_select1')?Input::old('my_multi_select1'):GeneralHelper::getAssignedUsers($trackable_id); ?>
							<select multiple="multiple" class="multi-select" id="my_multi_select1" name="my_multi_select1[]">
								@if($users)
									@foreach ($users as $k => $val) 									
									  <option value="{{ $k }}" <?php echo in_array($k, $old_links)?'selected':''; ?>>{{ $val }}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-offset-3 col-lg-8">
							<button class="btn btn-success" type="submit">Save</button> &nbsp;&nbsp;
							<a href="{{ URL::to('admin/trackables/assign_users/'.$trackable_id) }}" ><button class="btn btn-default" type="button">Cancel</button></a>
						</div>
					</div>
					{{ Form::close() }}
			</section>
		</div>
	</section>	
</section>

<script type="text/JavaScript">
	jQuery(document).ready( function() {
		jQuery('.flash-message').delay(3000).fadeOut();
	});
   
	$('#my_multi_select1').multiSelect({ 
	  selectableHeader: "<div class='custom-header'>All Users</div>",
	  selectionHeader: "<div class='custom-header'>Assigned Users</div>"
	});
</script>
@stop
