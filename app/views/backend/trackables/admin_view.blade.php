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
				Trackables
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
					<a href="javascript:;">{{'Detail of : ' .$Trackable->name }}</a> 
					<span class="divider-last">&nbsp;</span>
				</li>
				
			</ul>
		</div>
	</div>
	
	
	
	<div class="row">
		<div class="col-lg-12">
			<section class="panel"> 
				<header class="panel-heading">
					Detail of : {{$Trackable->name}}
				</header>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							
							<h4>{{ $Trackable->name }}</h4>
							 
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Image</b></div>
								<div class="col-lg-8">{{ GeneralHelper::showTrackableImg($Trackable->image, '', '48%', '',$Trackable->name,'thumb') }}  </div>
							</div><br/>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Unit</b></div>
								<div class="col-lg-8">: {{ $Trackable->unit }} </div>
							</div>
							
							
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Alert</b></div>
								<div class="col-lg-8">: {{ $Trackable->	alert}} </div>
							</div>
							
							
							
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Alert Frequency</b></div>
								<div class="col-lg-8">: {{ $Trackable->alert_frequence!=''?$Trackable->alert_frequence:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Logic If Greaterthen</b></div>
								<div class="col-lg-8">: {{ $Trackable->logic_if_greaterthen!=''?$Trackable->logic_if_greaterthen:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Cancer Killer X</b></div>
								<div class="col-lg-8">: {{ $Trackable->cancer_killer_x!=''?$Trackable->cancer_killer_x:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Happy Heart X</b></div>
								<div class="col-lg-8">: {{ $Trackable->happy_heart_x!=''?$Trackable->happy_heart_x:'----' }} </div>
							</div>						
							
							 
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Weight Control X</b></div>
								<div class="col-lg-8">: {{ $Trackable->weight_control_x!=''?$Trackable->weight_control_x:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Mood Meter X</b></div>
								<div class="col-lg-8">: {{ $Trackable->mood_meter_x!=''?$Trackable->mood_meter_x:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Status</b></div>
								<div class="col-lg-8">: {{ Config::get('constants.STATUS.'.$Trackable->status) }} </div>
							</div>
							 
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Registered On</b></div>
								<div class="col-lg-8">: {{ date('F d,Y', strtotime($Trackable->created_at)) }} </div>
							</div>
							
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Updated On</b></div>
								<div class="col-lg-8">: {{ date('F d,Y', strtotime($Trackable->updated_at)) }} </div>
							</div>
						</div>
					</div>
					<div class="row panel-spacing" style="margin-top:30px;" >
						<div class="col-lg-12"><a class="btn btn-default" href="{{ URL::to('admin/trackables')}}" ><i class='fa fa-reply'> Back</i></a></div>
					</div>
				</div>
			</section>
		</div>
	</div>
</section>
@stop																													