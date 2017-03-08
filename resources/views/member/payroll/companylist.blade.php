@extends('member.layout')
@section('css')
@endsection
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-building-o"></i>
            <h1>
                <span class="page-title">Company List</span>
                <small>
                    List of Company
                </small>
            </h1>
            <button class="btn btn-custom-primary panel-buttons pull-right">Create Company</button>
           
        </div>
    </div>
</div>

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#active-company"><i class="fa fa-star" aria-hidden="true"></i>&nbsp;Active Company</a></li>
  <li><a data-toggle="tab" href="#archived-company"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Archived Company</a></li>
</ul>

<div class="tab-content tab-pane-div">
  <div id="active-company" class="tab-pane fade in active">
   	<table class="table table-condensed table-bordered table-hover">
   		<thead>
   			<tr>
   				<th class="text-center">Company Name</th>
   				<th class="text-center">Company Code</th>
   				<th class="text-center">Company RDO</th>
   				<th class="text-center">Action</th>
   			</tr>
   		</thead>
   	</table>
  </div>
  <div id="archived-company" class="tab-pane fade">
   
  </div>
</div>
@endsection
@section('script')
@endsection