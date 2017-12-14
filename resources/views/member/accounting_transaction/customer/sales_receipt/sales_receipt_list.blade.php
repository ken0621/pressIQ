@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
            <span class="page-title">{{$page or ''}}</span>
            <small>
            Insert Description Here
            </small>
            </h1>
            <div class="dropdown pull-right">
                <button onclick="location.href=''" class="btn btn-primary"><i class="fa fa-star"></i> Create Sales Receipt</button>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray "  style="margin-bottom: -10px;">
    <ul class="nav nav-tabs">
        <li class="active change-tab pending-tab cursor-pointer" mode="pending"><a class="cursor-pointer"><i class="fa fa-folder-open-o"></i> Open</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="fa fa-folder-o"></i> Close</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="all"><a class="cursor-pointer"><i class="fa fa-list"></i> All</a></li>
    </ul>
    <div class="search-filter-box">
        <div class="col-md-3" style="padding: 10px">
        </div>
        <div class="col-md-3" style="padding: 10px">
        </div>
        <div class="col-md-2" style="padding: 10px">
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
                                    <th >NAME</th>
                                    <th class="text-center">REFERENCE NUMBER</th>
                                    <th class="text-center">TRANSACTION DATE</th>
                                    <th class="text-center" width="120px">TOTAL PRICE</th>
                                    <th class="text-center" width="100px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Asiawide Refreshment Corporation <br>
                                        <small> Juan Dela Cruz </small>
                                    </td>
                                    <td class="text-center">SR20171214-00001</td>
                                    <td class="text-center">December 14, 2017</td>
                                    <td class="text-center">1,500.00</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-custom">
                                                <li><a href="javascript">PRINT</a></li>
                                            </ul>
                                        </div>
                                    </td>
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