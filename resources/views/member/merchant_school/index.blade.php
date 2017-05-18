@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Merchant School</span>
                <small>
                    Temporary Alternative for merchant module
                </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block col-md-4" id="top">
    <div class="panel-heading">
        <div>
            <div class="col-md-12">
                <form class="global-submit" method="post" action="/member/mlm/merchant_school/create">
                {!! csrf_field() !!}
                <label>Choose Items To Be Used.</label>
                <select class="drop-down-item" name="item_id">
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                </select>
                <hr>
                <button class="btn btn-primary pull-right">Choose Items</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block col-md-3" id="top">
    <div class="panel-heading">
        <div>
            <table class="table table-bordered">
                <th>Item List</th>
                <th></th>

                <tbody class="get_body"></tbody>
            </table>
        </div>
    </div>
</div>


<div class="panel panel-default panel-block panel-title-block col-md-12" id="top">
    <div class="panel-heading">
        <div>
            <div class="col-md-3">
                <label>Status</label>
                <select class="form-control s_status">
                    <option value="all">All</option>
                    <option value="0">Pending</option>
                    <option value="1">Not Used</option>
                    <option value="2">Used</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Search By:</label>
                <select class="form-control s_search_by">
                    <option value="all">All</option>
                    <option value="customer_name">Customer Name</option>
                    <option value="order">Order #</option>
                    <option value="code">Code</option>
                    <option value="s_id">Student Id</option>
                    <option value="s_name">Student Name</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Search</label>
                <div class="input-group">
                  <input type="text" class="form-control s_input" placeholder="Search">
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" style="color: black;">Go!</button>
                  </span>
                </div>
            </div>
            <div class="col-md-12"><hr></div>
            <div class="col-md-12">
                <div class="tbl_append">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
var base_link = '/member/mlm/merchant_school/get/table';
var link = '/member/mlm/merchant_school/get/table';
get_body();
reaload_table();
$('.drop-down-item').globalDropList({
    link_size               : "md"
});

function  submit_done (data) {
    if(data.status == 'success')
    {
        get_body();
        reaload_table();
        toastr.success(data.message)
    }
    else
    {
        get_body();
        reaload_table();
        toastr.error(data.message);
    }
}
function get_body()
{
    $('.get_body').html('<tr><td>Loading Items...</td><td></td></tr>');
    $('.get_body').load('/member/mlm/merchant_school/get');
}
$('.s_input').on('change',  function (){
    var s_status = $('.s_status').val();
    var s_search_by = $('.s_search_by').val();
    var s_input = $('.s_input').val();

    link = base_link + '?s_status=' + s_status + '&s_search_by=' + s_search_by + '&s_input=' + s_input; 
    console.log("link", link);
    reaload_table();
});
$('.s_status').on('change', function(){
    var s_status = $('.s_status').val();
    link = base_link + '?s_status=' + s_status;
    reaload_table();
});
function reaload_table()
{
    $('.tbl_append').html('<tr><td>Loading Items...</td><td></td></tr>');
    $('.tbl_append').load(link);
}
</script>
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
@endsection