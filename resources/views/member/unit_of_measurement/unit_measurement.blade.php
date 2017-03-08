@extends('member.layout')

@section('css')
@endsection

@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-line-chart"></i>
            <h1>
                <span class="page-title">Unit Of Measurements</span>
                <small>
	                Manage your unit of measurements.
                </small>
            </h1>
            
            <a href="javascript:" size="lg" class="panel-buttons btn btn-custom-primary pull-right popup" link="/member/item/unit_of_measurement/add" >Add U/M</a>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
	<div class="panel-body form-horizontal">
		<div class="form-group">
			<div class="col-md-6">
				<ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#"><i class="fa fa-star" aria-hidden="true"></i>&nbsp;Active U/M</a></li>
				  <li><a data-toggle="tab" href="#"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Archived U/M</a></li>
				</ul>
			</div>
			<div class="col-md-4 pull-right">
				<div class="input-group">
					<span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
					<input type="search" name="" class="form-control" placeholder="Start typing category">
				</div>
			</div>
		</div>
		<div class="form-group panel-body unit-m-container">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>U/M Set Name</th>
						<th class="text-center">Base U/M</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody class="table-category">
					@if($_um)
						@foreach($_um as $um)
							<tr>
								<td>{{$um->um_name}}</td>
								<td>{{$um->um_base_name}} ({{$um->um_base_abbrev}})</td>
								<td class="text-center"><a link="/member/item/unit_of_measurement/edit/{{$um->um_id}}" size="lg" class="popup">Edit</a></td>

							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
		
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/manage_category_list.js"></script>
<script type="text/javascript" src="/assets/member/js/unit_measurement.js"></script>
<script type="text/javascript">
	
function submit_done(data)
{	
	if(data.status == "success")
    {
        toastr.success("Success");
        $(".unit-m-container").load("/member/item/unit_of_measurement .unit-m-container");
        data.element.modal("hide");
    }
    else if(data.status == "error")
    {
        toastr.warning(data.status_message);
        $(data.target).html(data.view);
    }
}
</script>
@endsection