@extends('backend/layouts/default')
@section('title')
	Trackables
@parent

@stop


@section('content')


@if (Session::has('message'))
<div class="flash-message success-msg">{{ Session::get('message') }}</div>
@endif

<section class="wrapper site-min-height">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-title">
				Removed Trackables
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
					<a href="javascript:;">Removed Trackables</a> 
					<span class="divider-last">&nbsp;</span>
				</li>
				
			</ul>
		</div>
	</div> 
	
	
	
	<div class="row">
		{{ Form::open(array('url' => array('admin/trackables/'),'class' => 'cmxform form-horizontal tasi-form', 'name'=>'searchUser')) }}
		<div class="col-lg-12">
			<section class="panel">
				<h3 class="panel-heading">Search </h3>
				<div class="panel-body">
					<div class="form">
						
						<div class="form-group">
							<div class="col-lg-3">
								{{ Form::text('name', isset($_POST['name'])?trim($_POST['name']):null, array('id' => 'name','placeholder'=>'Search by name', 'class' => 'form-control')) }}	
							</div>
							<div class="col-lg-3">
								{{ Form::text('alert', isset($_POST['alert'])?trim($_POST['alert']):null, array('id' => 'alert','placeholder'=>'Search by alert', 'class' => 'form-control')) }}
							</div>
							<div class="col-lg-6">
								<button class="btn btn-success" type="submit">Search</button> &nbsp;&nbsp;
								<a href="{{ URL::to('admin/users/'.$role_id) }}" ><button class="btn btn-default" type="button">Show All</button></a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		{{ Form::close() }}
	</div>
	
	<section class="panel">
		<header class="panel-heading">
			
		</header>
		<!-- BEGIN PAGE HEADER-->
		
		<div class="panel-body">
			<section id="unseen">
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<th>{{ SortableTrait::link_to_sorting_action('name', 'Name' ) }}</th>
							<th >{{ SortableTrait::link_to_sorting_action('unit', 'Unit') }}</th>
							
							<th >{{ SortableTrait::link_to_sorting_action('alert', 'Alert') }}</th>
							
							<th class="">Action</th>
						</tr>
					</thead>
					<tbody>	
						@if(! $users->isEmpty())
						@foreach ($users as $val)
						<tr>
							<?php $name = ucwords(strtolower($val->name )); ?>
							<td>
								{{ HTML::linkAction('TrackableController@admin_view', $name, array($val->id), array( 'title'=>$name)) }}
							</td>
							<td>{{  $val->email }}</td>
							
							<td >{{ ($val->mobile)?$val->mobile:'---' }}</td>
							
							
							<td >
							
								<a title="Deactivate" href="{{ URL::to('admin/trackables/admin_account_recover/'.$val->id) }}"><span class="label label-success label-mini">&nbsp; Recover Account &nbsp;</span></a>
			
								<a href="#remove_{{ $val->id }}" data-toggle='modal' class="label label-danger label-mini" title="Remove"><i class="fa fa-trash-o"></i>&nbsp;Remove Permanently </a>
								
								<div class="modal fade" id="remove_<?php echo $val->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h3 class="modal-title">Remove </h3>
											</div>
											<div class="modal-body">Are you sure, you want to remove Permanently this {{ Config::get('constants.USER_ROLES.'.$val->role_id) }} ?</div>
											<div class="modal-footer">
												{{ HTML::linkAction('TrackableController@admin_permanently_delete', 'Confirm', array($val->id), array('class'=>'btn btn-primary','title'=>'Confirm Remove')) }}
												<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
						@else
										<tr>
											<td colspan="6" ><p class="no-record"> No records found! </p>
										</tr>
									@endif
					</tbody>
				</table>
				
				
			</section>
		</div>
	</section>	
</section>

<script type="text/JavaScript">
	jQuery(document).ready( function() {
		jQuery('.flash-message').delay(3000).fadeOut();
	});
	
</script>
@stop
