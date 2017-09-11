@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
	            <span class="page-title">Product Codes</span>
	            <small>
	            You can see product codes from here
	            </small>
            </h1>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <ul class="nav nav-tabs">
        <!-- <li class="active change-tab pending-tab cursor-pointer" mode="pending"><a class="cursor-pointer"><i class="fa fa-check"></i> All</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="fa fa-money"></i> Sold Codes</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="fa fa-star"></i> Used Codes</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer"><i class="fa fa-warning"></i> Blocked Codes</a></li> -->
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
                <input type="text" class="form-control search-employee-name" placeholder="Search Activation or Pin" aria-describedby="basic-addon1">
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
                                    <th class="text-center" width="300px">Pin No.</th>
                                    <th class="text-center" width="200px">Activation</th>
                                    <th class="text-center" width="400px">Item Name</th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($_item_product_code as $item)
                                <tr>
                                    <td class="text-center">{{$item->mlm_pin}}</td>
                                    <td class="text-center">{{$item->mlm_activation}}</td>
                                    <td class="text-center">{{$item->item_name}}</td>
                                    <td class="text-center"><a href="">Use Code</a></td>
                                    <td class="text-center"><a href="">Block Code</a></td>
                                </tr>
                                @endforeach
                               <!--  <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">AT4YM1BU</td>
                                    <td class="text-center">GOLD</td>
                                    <td class="text-center">GOLD KIT A</td>
                                    <td class="text-center"><a href="">Use Code</a></td>
                                    <td class="text-center"><a href="">Block Code</a></td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection