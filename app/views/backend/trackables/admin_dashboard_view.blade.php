@extends('backend/layouts/default')

@section('title')
	Trackable Management 
@stop



@section('content')
@include('backend/alert_message')
<section class="wrapper site-min-height">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-title">
				Trackable Values Of {{ $users->name}}
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
					<a href="{{ URL::to('admin/trackables') }}">Trackables</a> 
					<span class="divider">&nbsp;</span>
				</li>
				
				<li>
					<a href="javascript:;">Trackable values</a> 
					<span class="divider-last">&nbsp;</span>
				</li>
				
			</ul>
		</div>
	</div>
	
	
	
	<section class="panel">
		<header class="panel-heading">
			<!--<p><strong>Trackable Name</strong> : {{$Trackable->name}}</p><p><strong>Alert</strong> : {{ $Trackable->alert }}</p>-->
		</header>
		<div class="panel-body">
			<section id="unseen"> 
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<th>{{ SortableTrait::link_to_sorting_action('name', 'Name' ) }}</th>
							<th class="hidden-phone">{{ SortableTrait::link_to_sorting_action('alert', 'Alert') }}</th>
							<th class="hidden-phone">{{ SortableTrait::link_to_sorting_action('value', 'value') }}</th>
							<th class="hidden-phone">{{ SortableTrait::link_to_sorting_action('cancer_killer_x', 'Cancer Killer X') }}</th>
							<th class="hidden-phone">{{ SortableTrait::link_to_sorting_action('happy_heart_x', 'Happy Heart X') }}</th>
							<th class="hidden-phone">{{ SortableTrait::link_to_sorting_action('weight_control_x', 'Weight Control X') }}</th>
							<th class="hidden-phone">{{ SortableTrait::link_to_sorting_action('mood_meter_x', 'Mood Meter X') }}</th>
							<th class="hidden-phone">{{ SortableTrait::link_to_sorting_action('created_at', 'Date') }}</th>
							<th class="">Action</th>
						</tr>
					</thead>
					<tbody>
						@if(!$Trackable_values->isEmpty())
							@foreach ($Trackable_values as $val)
						
								<tr>
									<td>{{  $val->name }}</td>
									<td class="hidden-phone">{{  $val->alert }}</td>
									<td class="hidden-phone">{{  $val->value }}</td>
									<td class="hidden-phone">{{  $val->cancer_killer_x }}</td>
									<td class="hidden-phone">{{  $val->happy_heart_x }}</td>
									<td class="hidden-phone">{{  $val->weight_control_x }}</td>
									<td class="hidden-phone">{{  $val->mood_meter_x }}</td>
									<td class="hidden-phone">{{  date("M d, Y", strtotime($val->created_at))}}</td>
									<td class="center" style="width:8%;">
										<a href="#remove_{{ $val->id }}" data-toggle='modal' class='red' title="Remove"><i class="fa fa-trash-o"></i>&nbsp;Remove</a>
										<div class="modal fade" id="remove_<?php echo $val->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														<h3 class="modal-title">Remove</h3>
													</div>
													<div class="modal-body">Are you sure, you want to remove this trackable value ?</div>
													<div class="modal-footer">
														{{ HTML::linkAction('TrackableController@admin_dashboard_remove_view', 'Confirm', array($val->id), array('class'=>'btn btn-primary','title'=>'Confirm Remove')) }}
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
								<td colspan="7" ><p class="no-record"> No records found! </p>
							</tr>
						@endif
					</tbody>
				</table>
					<div align="right" class="no_records" >{{ $Trackable_values->links()}}</div>
			</section>
		</div>
	</section>
</section>
@stop																													