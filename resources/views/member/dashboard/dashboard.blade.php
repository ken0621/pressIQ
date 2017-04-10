@extends('member.layout')
@section('content')

@if(isset($pis) && $pis != 0)
<div class="row">
   <div class="form-group">
        <div class="col-md-12 text-center">
            <h2>{{$shop_name or ''}}</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group reports-class">
        <div class="col-md-3 col-xs-3 po-class"> 
            <span>{{$po_amount or ''}}</span><br>
            <span>{{$count_po or 0}} Purchase Orders</span>
        </div>
        <div class="col-md-3 col-xs-3 ar-class">
            <span>{{$ar_amount or ''}}</span><br>
            <span>{{$count_ar or 0}} Account Receivable</span>
        </div>
        <div class="col-md-3 col-xs-3 sales-class">
            <span>{{$sales_amount or ''}}</span><br>
            <span>Sales</span>
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-md-12 text-center">
        <h3>Welcome to Digima House</h3>
    </div>
</div>

<!-- TRIAL COUNT DOWN -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="trial-warning clearfix">
            <!-- <div class="word-warning pull-left">You have 23 days left of your trial</div> -->
            <a class="pull-right btn btn-success" href="">Select Plan</a>
        </div>
    </div>
</div>

<!-- ADVICE FOR STARTUPS -->
<div class="row text-center">
    <div class="col-md-12">
        <div class="title-advice"><i class="fa fa-comment"></i> Here's some tips to setup your shop</div>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <div class="simple-advice clearfix">
            <form type="post" action="member/utilities/make-developer">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="pwd" placeholder="Type developer password here (hint: as usual)">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="submit">Let Me Access All Page</button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4 col-md-offset-2">
        <div class="simple-advice clearfix">
            <div class="advice-word">Add an item to buy or sell</div>
            <a class="btn btn-primary" href="/member/ecommerce/product/add">Add Item</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="simple-advice clearfix">
            <div class="advice-word">Add a customer to do a transaction</div>
            <a class="btn btn-primary" href="/member/ecommerce/product/add">Add Customer</a>
        </div>
    </div>
    <div class="col-md-4 col-md-offset-2">
        <div class="simple-advice clearfix">
            <div class="advice-word">Add a vendor to do a transaction</div>
            <a class="btn btn-primary" href="/member/ecommerce/product/add">Add Vendor</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="simple-advice clearfix">
            <div class="advice-word">Add a product to see it in your store</div>
            <a class="btn btn-primary" href="/member/ecommerce/product/add">Add Ecommerce Product</a>
        </div>
    </div>
   <!--  <div class="col-md-8 col-md-offset-2">
        <div class="simple-advice clearfix">
            <div class="advice-word">Add a product to see it in your store</div>
            <a class="btn btn-primary" href="/member/ecommerce/product/add">Add a product</a>
        </div>
    </div> -->
    <div class="col-md-4 col-md-offset-2">
        <div class="simple-advice clearfix">
            <div class="advice-word">Customize the look of your website</div>
            <a class="btn btn-primary" href="/member/page/themes">Select Theme</a>
        </div>
    </div>
    <!-- <div class="col-md-8 col-md-offset-2">
        <div class="simple-advice clearfix">
            <div class="advice-word">Setup a custom domain name</div>
            <a class="btn btn-primary" href="">Add a domain</a>
        </div>
    </div> -->
</div>


@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/assets/member/css/dashboard.css">
@endsection
@section('script')
<script type="text/javascript">
    $(".drop-down-any").globalDropList();
    @if(Session::has('success'))
        toastr.success('{{Session::get('success')}}');
    @elseif(Session::has('error'))
        toastr.error('{{Session::get('error')}}');
    @endif

</script>
@endsection