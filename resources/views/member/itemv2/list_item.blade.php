@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-cart-plus"></i>
            <h1>
            <span class="page-title">Item List</span>
            <small>
                 List of Products / Services you are selling
            </small>
            </h1>

            <div class="dropdown pull-right">
                <button onclick="location.href=''" class="btn btn-def-white btn-custom-white"><i class="fa fa-gear"></i> Columns</button>
                <button onclick="action_load_link_to_modal('/member/item/v2/add', 'lg')" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</button>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block panel-gray">
    <ul class="nav nav-tabs">
        <li class="active change-tab pending-tab cursor-pointer" mode="pending"><a class="cursor-pointer go-default"><i class="fa fa-check"></i> Active</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer go-archive"><i class="fa fa-trash"></i> Archived</a></li>
    </ul>
    <div class="search-filter-box">
        <div class="col-md-3" style="padding: 10px">
            <select class="form-control">
                <option value="0">All Item Type</option>
                <option value="1">Inventory</option>
                <option value="2">Non-Inventory</option>
                <option value="3">Bundle</option>
            </select>
        </div>
        <div class="col-md-3" style="padding: 10px">
            <select class="form-control">
                <option value="0">All Category</option>
            </select>
        </div>
        <div class="col-md-2" style="padding: 10px">
        </div>
        <div class="col-md-4" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search-employee-name" placeholder="Search Item" aria-describedby="basic-addon1">
            </div>
        </div>  
    </div>
    <div class="tab-content codes_container" style="min-height: 300px;">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
                <div class="clearfix">
                    <div class="col-md-12">
                        <div class="table-responsive load-item-table"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/item/item_list.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    $('.go-default').unbind("click");
    $('.go-default').bind("click", function(e)
    {
        action_archive(0, e.currentTarget);
    });

    $('.go-archive').unbind("click");
    $('.go-archive').bind("click", function(e)
    {
        action_archive(1, e.currentTarget);
    });

    $("body").on('click', '.item-archive', function(event) 
    {
        event.preventDefault();
        var item_id = $(event.currentTarget).attr("item-id");
        action_item_archive(item_id, "archive");
    });

    $("body").on('click', '.item-restore', function(event) 
    {
        event.preventDefault();
        var item_id = $(event.currentTarget).attr("item-id");
        action_item_archive(item_id, "restore");
    });
});

function action_archive(archive, x)
{
    window.history.pushState( {} , '', '?archived='+archive );
    load_table_data.archived = archive;
    item_list.action_load_table(); 
    $('.nav-tabs li').removeClass('active'); 
    $(x).parent().addClass('active');
}

function action_item_archive(item_id, action)
{
    $.ajax({
        url: '/member/item/v2/'+action,
        type: 'GET',
        dataType: 'json',
        data: {
            item_id: item_id
        },
    })
    .done(function() {
        item_list.action_load_table(); 
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}
</script>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/assets/member/css/item_add_v2.css">
<style type="text/css">
    .wrapper.extended.scrollable
    {
        overflow: hidden;
    }
</style>
@endsection
