@extends('member.payroll2.employee_dashboard.employee_layout')
@section('content')
<div class="page-title">
    <h3>{{ $page }}</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">{{ $page }}</li>
        </ol>
    </div>
</div>


<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <ul class="nav nav-tabs">

        <li class="active cursor-pointer change-tab approve-tab" mode="processed"><a class="cursor-pointer"><i class="text-bold"> Pending </i></a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="text-bold"> Approved </i></a></li>
  
    </ul>
    
    
    <div class="tab-content codes_container">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
                <div class="clearfix">
                    <div class="col-md-12">
                        <div class="table-responsive load-table-employee-list">
						    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection