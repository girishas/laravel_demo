@extends('backend/layouts/default')
<?php  $title = (Route::input('user_id') == 'all' OR Route::input('user_id') == 'deleted')?ucfirst(Route::input('user_id')):""; ?>
@section('title')
	{{$title}} A/R Imported Data
@stop

@section('content')

@alert('backend/alert_message')

<section class="wrapper site-min-height">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-title">
				A/R Imported Data
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
					<a href="{{ URL::to('admin/users/import_data_list/'.Route::input('user_id')) }}">{{$title}} A/R Imported Data</a> 
					<span class="divider">&nbsp;</span>
				</li>
				
				<li>
					<a href="javascript:;">{{$title .' A/R Imported Data : ' .$data->name }}</a> 
					<span class="divider-last">&nbsp;</span>
				</li>
				
			</ul>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<section class="panel"> 
				<header class="panel-heading">
					{{$title .' A/R Imported Data : ' .$data->name }}
				</header>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<h4>{{ $data->name }}</h4>
							 @if(Auth::id() != $data->company_id)
								<div class="row panel-spacing">
									<div class="col-lg-4"><b>User</b></div>
									<div class="col-lg-8">: {{ $data->comp_name }} </div>
								</div>
							@endif
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Insurance ID</b></div>
								<div class="col-lg-8">: {{ $data->insurance_id}} </div>
							</div>
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Insurance Company</b></div>
								<div class="col-lg-8">: {{ $data->insurance_company!=''?$data->insurance_company:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Code</b></div>
								<div class="col-lg-8">: {{ $data->code!=''?$data->code:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Date From</b></div>
								<div class="col-lg-8">: {{ $data->date_from!=''?$data->date_from:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Date To</b></div>
								<div class="col-lg-8">: {{ $data->date_to!=''?$data->date_to:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Billed Amount</b></div>
								<div class="col-lg-8">: {{ $data->billed_amount!=''?"$".$data->billed_amount:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Paid Amount</b></div>
								<div class="col-lg-8">: {{ $data->paid_amount!=''?"$".$data->paid_amount:'----' }} </div>
							</div>
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>AR Amount</b></div>
								<div class="col-lg-8">: {{ $data->AR_amount!=''?"$".$data->AR_amount:'----' }} </div>
							</div>
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Status</b></div>
								<div class="col-lg-8">: {{ $data->status!=''?"$".$data->status:'----' }} </div>
							</div>
							 
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Imported On</b></div>
								<div class="col-lg-8">: {{ date('F d,Y', strtotime($data->created_at)) }} </div>
							</div>
							
							
							<div class="row panel-spacing">
								<div class="col-lg-4"><b>Updated On</b></div>
								<div class="col-lg-8">: {{ date('F d,Y', strtotime($data->updated_at)) }} </div>
							</div>
						</div>
					</div>
					<div class="row panel-spacing" style="margin-top:30px;" >
						<div class="col-lg-12"><a class="btn btn-default" href="{{ URL::to('admin/users/import_data_list/'.Route::Input('user_id'))}}" ><i class='fa fa-reply'> Back</i></a></div>
					</div>
				</div>
			</section>
		</div>
	</div>
</section>
@stop																													