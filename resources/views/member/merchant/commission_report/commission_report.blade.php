@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
            <span class="page-title">Commission Report</span>
            <small>
            Insert Description Here
            </small>
            </h1>
            <div class="dropdown pull-right">
                <button onclick="location.href=''" class="btn btn-def-white btn-custom-white"><i class="fa fa-check"></i> Secondary Command</button>
                <button onclick="location.href=''" class="btn btn-primary"><i class="fa fa-star"></i> Primary Command</button>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray col-md-6">
    <div class="tab-content">
    <form class="global-submit" method="post" action="/member/merchant/commission-report">
    {!! csrf_field() !!}
        <div id="all-orders" class="tab-pane fade in active">
            <div class="panel-heading">
            <center>Commission Settings</center>
            <div class="col-md-12">
                <label>Commission Percentage</label>
                <input type="number" min="0" value="{{$percentage}}" class="form-control commission-percentage" name="merchant_commission_percentage">
                <hr>
                <button class="btn btn-primary pull-right">Save</button>
            </div>
            </div>
        </div>
    </form>    
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray col-md-12"  style="margin-bottom: -10px;">
    <div class="search-filter-box">
        <div class="col-md-3" style="padding: 10px">
            <!-- <select class="form-control">
                <option value="0">All</option>
                <option value="1">Current Warehouse</option>
            </select> -->
        </div>
        <div class="col-md-3" style="padding: 10px">
            <!-- <select class="form-control">
                <option value="0">Filter Sample 002</option>
            </select> -->
        </div>
        <div class="col-md-2" style="padding: 10px">
        </div>
        <div class="col-md-4" style="padding: 10px">
            <!-- <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search-employee-name" placeholder="Search by employee name / number" aria-describedby="basic-addon1">
            </div> -->
        </div>
    </div>
    <div class="tab-content codes_container" style="min-height: 300px;">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="clearfix">
                <div class="col-md-12">
                    <div class="table-responsive load-table-here">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
<script type="text/javascript" src="/assets/themes/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/commission_report.js?v=3"></script>
<script type="text/javascript">
    function success(data)
    {
        toastr.success('Setting saved');
        commission_report.action_load_table();
    }
</script>