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
                <label>Choose Category</label>
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


@endsection
@section('script')
<script type="text/javascript">
get_body();
$('.drop-down-item').globalDropList({
    link_size               : "md"
});
function  submit_done (data) {
    if(data.status == 'success')
    {
        get_body();
        toastr.success(data.message)
    }
    else
    {
        get_body();
        toastr.error(data.message);
    }
    // body...
}
function get_body()
{
    $('.get_body').html('<tr><td>Loading Items...</td><td></td></tr>');
    $('.get_body').load('/member/mlm/merchant_school/get');
}
</script>
@endsection