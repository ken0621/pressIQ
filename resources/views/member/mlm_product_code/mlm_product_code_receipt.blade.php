@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Product Codes Receipt</span>
                <small>
                    The product code receipt are shown here.
                </small>
            </h1>
            <!-- <a href="/member/mlm/code/sell" class="panel-buttons btn btn-primary pull-right">Sell Codes</a> -->
            <a href="/member/mlm/product_code" class="panel-buttons btn btn-default pull-right">Back</a>
        </div>
    </div>
</div>
<!-- NO PRODUCT YET -->
<div class="panel panel-default panel-block panel-title-block panel-gray col-md-6 ">
    <ul class="nav nav-tabs">
        <li class="active cursor-pointer"><a class="cursor-pointer" data-toggle="tab" href="#all"><i class="fa fa-star"></i> All Invoice</a></li>
        <!-- <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab" href="#archived"><i class="fa fa-trash"></i> Archived Items</a></li> -->
    </ul>
    <div class="search-filter-box">
        <div class="col-md-4 col-md-offset-4" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search_email" placeholder="Search by email" aria-describedby="basic-addon1" onchange="search_email(this)">
            </div>
        </div>  
    </div>
    <div class="tab-content codes_container">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="load-data" target="invoice_append">
                <div id="invoice_append">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>Invoice ID</th>
                            <th>Customer Name</th>
                            <th>Invoice Date Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        @foreach($_invoice as $invoice)
                        <tr>
                            <td>{{$invoice->item_code_invoice_id}}</td>
                            <td>{{$invoice->first_name}} {{$invoice->middle_name}} {{$invoice->last_name}}</td>
                            <td>{{$invoice->item_code_date_created}}</td>
                            <td>
                                <a href="javascript:" onClick="append_to('/member/mlm/product_code/receipt/view/{{$invoice->item_code_invoice_id}}')" >
                                    View
                                </a>
                                ||
                                <a target="_blank" href="/member/mlm/product_code/receipt/view/{{$invoice->item_code_invoice_id}}?pdf=true" >
                                    PDF
                                </a>
                            </td>
                        </tr> 
                        @endforeach
                     
                    </tbody>

                </table>
                @if(count($_invoice) == 0)
                <center>No Invoice Available</center>
                @endif   
                <center>{!! $_invoice->render() !!}</center>
            </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray col-md-6 ">
    <div class="tab-content codes_container">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="table-responsive">
                <center>Receipt</center>
                <div class="append_receipt"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    <?php $invoice = Request::input('invoice_id'); ?>
    @if($invoice != null)
        append_to('/member/mlm/product_code/receipt/view/{{$invoice}}')
    @endif
    function append_to(link)
    {
        // $('.append_receipt')..
        $('.append_receipt').html('<center><div class="loader-16-gray"></div></center>');
        $('.append_receipt').load(link);
    }
    function search_email(ito)
    {
        var search = $(ito).val();
        var link ='/member/mlm/product_code/receipt?search_name=' + search + ' #invoice_append';
        $('#invoice_append').load(link);
    }
</script>
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
<!--     <script type="text/javascript">
        $(".popup").click(function()
        {
            $(".modal-content").css("min-height","700px");
        });
    </script> -->
@endsection