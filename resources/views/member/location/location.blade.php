
@extends('member.layout')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Location &raquo; List </span>
                <small>
                    List of Location
                </small>
            </h1>
            <a class="panel-buttons btn btn-custom-primary pull-right popup" size="sm" link="/member/maintenance/location/location" >New Term</a>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block panel-gray ">
     <div class="panel-body">
        
        <div class="search-filter-box">
            <div class="col-md-4 col-md-offset-8" style="padding: 10px">
                <div class="input-group">
                    <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control global-search" url="" data-value="1" placeholder="Press Enter to Search" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div id="active" class="tab-pane fade in active">
                <div class="load-data" target="active_location" filter="active">
                    <div id="active_location">
                         <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-center">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($_location as $location)
                                    <tr>
                                        <td class="text-center">{{ $location->locale_name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center pull-right">
                            {!!$_location->render()!!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div id="inactive" class="tab-pane fade in">
                <div class="load-data" target="inactive_location" filter="inactive">
                    <div id="inactive_location">
                        
                    </div>
                </div>
            </div> -->
        </div>

    </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
<script>
var coupon_code = new coupon_code();

function coupon_code()
{
    init();
    function init()
    {
        document_ready();
    }

    function document_ready()
    {

    }
}

function submit_done(data)
{
    if(data.status == "success")
    {
        toastr.success(data.message);
        data.element.modal("toggle");
        $("#active .load-data").load("/member/maintenance/location/list #active_location");

    }
    else
    {
        toastr.error(data.message);
    }
}
</script>
@endsection