@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <input type="hidden" id="_token" value="{{csrf_token()}}" name="">
    <div class="panel-heading">
        <div>
            <i class="fa fa-building"></i>
            <h1>
                <span class="page-title">Warehouse</span>
                <small>
                    List of warehouse.
                </small>
            </h1>
            <div class="text-right">
                <a class="btn btn-primary panel-buttons popup" link="/member/item/v2/warehouse/add" size="lg" data-toggle="modal" data-target="#global_modal">Add Warehouse</a>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-6">
                <ul class="nav nav-tabs">
                  <li id="all-list" class="active"><a data-toggle="tab" href="#all"><i class="fa fa-star" aria-hidden="true"></i>&nbsp;Active Warehouse</a></li>
                  <li id="archived-list"><a data-toggle="tab" href="#archived"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Archived Warehouse</a></li>
                </ul>
            </div>
            <div class="col-md-4 pull-right">
                <div class="input-group">
                    <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <input type="search" name="" class="form-control srch-warehouse-txt" placeholder="Start typing warehouse">
                </div>
            </div>
        </div>

        <div class="form-group tab-content panel-body warehouse-container">
            <div id="all" class="tab-pane fade in active">
                <div class="table-responsive">
                    <div class="load-data" target="warehouse-table-list">
                        <div id="warehouse-table-list">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Warehouse Name</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="table-warehouse">
                                    @if(count($_warehouse) > 0)
                                    {!! $_warehouse_list !!}
                                    @else
                                    <tr>
                                        <td colspan="2" class="text-center">No Warehouse Found</td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center pull-right">
                               
                            </div>   
                        </div> 
                    </div>
                </div>
            </div>
            <div id="archived" class="tab-pane fade in">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">Warehouse Name</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-warehouse">
                        @if($_warehouse_archived != null)
                            @foreach($_warehouse_archived as $warehouse_archived)
                            <tr>
                                <td class="text-center">{{$warehouse_archived->warehouse_name}}</td>
                                <td class="text-center">
                                    <a href="javascript:" link="/member/item/warehouse/restore/{{$warehouse_archived->warehouse_id}}" href="javascript:" class="popup">RESTORE</a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script")
<script type="text/javascript" src="/assets/member/js/warehouse/warehousev2.js"></script>

<script type="text/javascript">
    
$('.droplist-vendor').globalDropList(
{ 
    width : "100%",
    link : "/member/vendor/add",
    onChangeValue : function ()
    {
        var vendor_id = $(this).val();
        if(vendor_id != "other")
        {
            var warehouse_id = $("#warehouse_id").val();
            $(".warehouse-refill-container").load("/item/warehouse/refill/by_vendor/"+warehouse_id+"/"+vendor_id +" .warehouse-refill-container") 
        }
    }
});
@endsection