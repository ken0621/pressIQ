@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
            <span class="page-title">GC Maintenance</span>
            <small>
                History of GC Maintenance is here.
            </small>
            </h1>
            <div class="dropdown pull-right">
                <button onclick="location.href=''" class="btn btn-def-white btn-custom-white"><i class="fa fa-check"></i> Import GC Maintenance</button>
                <button onclick="location.href=''" class="btn btn-primary"><i class="fa fa-star"></i> Generate GC Maintenance</button>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray "  style="margin-bottom: -10px;">
    <div class="search-filter-box">
        <div class="col-md-8" style="padding: 10px">
        </div>
        <div class="col-md-4" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search-employee-name" placeholder="Search by employee name / number" aria-describedby="basic-addon1">
            </div>
        </div>
    </div>
    <div class="tab-content codes_container" style="min-height: 300px;">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="clearfix">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead style="text-transform: uppercase">
                                <tr>
                                    <th class="text-center">ID.</th>
                                    <th class="text-center">Employee Name</th>
                                    <th class="text-center" width="120px">NET BASIC PAY</th>
                                    <th class="text-center" width="120px">GROSS PAY</th>
                                    <th class="text-center" width="120px">NET PAY<br>(TAKE HOME)</th>
                                    <th class="text-center" width="100px"></th>
                                    <th class="text-center" width="100px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">Sample Name</td>
                                    <td class="text-center">1,500.00</td>
                                    <td class="text-center">1,500.00</td>
                                    <td class="text-center">1,500.00</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection