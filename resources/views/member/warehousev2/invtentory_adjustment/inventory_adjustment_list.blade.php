@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
            <span class="page-title">{{$page}}</span>
            <small>
            List of {{$page}}
            </small>
            </h1>
            <div class="dropdown pull-right">
                <button onclick="location.href='/member/item/warehouse/inventory_adjustment/create'" class="btn btn-primary"><i class="fa fa-star"></i> Adjust Inventory</button>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray "  style="margin-bottom: -10px;">
    <ul class="nav nav-tabs">
        <li class="active change-tab pending-tab cursor-pointer" mode="pending"><a class="cursor-pointer"><i class="fa fa-check"></i> Open</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="fa fa-times"></i> Close</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="fa fa-trash"></i> All</a></li>
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
                            <thead>
                                <tr>
                                    <th class="text-center">SKU</th>
                                    <th class="text-center">ITEM DESCRIPTION</th>
                                    <th class="text-center">ACTUAL QUANTITY</th>
                                    <th class="text-center">NEW QUANTITY</th>
                                    <th class="text-center">DIFFERENCE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">000111</td>
                                    <td class="text-center">ITEM 1</td>
                                    <td class="text-center">10</td>
                                    <td class="text-center">20</td>
                                    <td class="text-center">10</td>
                                </tr>
                                 <tr>
                                    <td class="text-center">000222</td>
                                    <td class="text-center">ITEM 2</td>
                                    <td class="text-center">5</td>
                                    <td class="text-center">3</td>
                                    <td class="text-center">2</td>
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