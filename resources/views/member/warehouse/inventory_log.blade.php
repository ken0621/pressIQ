@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-building"></i>
            <h1>
                <span class="page-title">Inventory Logs</span>
            </h1>
            <div class="text-right">
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group tab-content panel-body inventory-log-container">
            <div id="all" class="tab-pane fade in active">
                <div class="form-group row clearfix">
                    <div class="col-md-4"> 
                        <div class="input-group">
                            <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control input-sm search-txt" warehouse_id={{$warehouse_id}} name="" placeholder="Search">
                        </div>
                    </div>
                </div>
                <div class="form-group order-tags"></div>
                <div class="inventory-log-table">
                    <div class="table-responsive">
                        <div class="load-data" target="inventory_table">
                            <div id="inventory_table"> 
                                @include("member.warehouse.inventory_log_table")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(".search-txt").unbind("keyup");
    $(".search-txt").bind("keyup", function()
    {
        warehouse_id = $(this).attr("warehouse_id");
        $(".inventory-log-table").load("/member/item/inventory_log_search/"+warehouse_id+"?search="+$(this).val(), function()
        {
            $(".load-data").attr("search",$(this).val());
            console.log("success");
        });
    });
</script>
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
@endsection