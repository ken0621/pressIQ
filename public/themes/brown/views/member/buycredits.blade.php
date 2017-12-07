@extends("member.member_layout")
@section("member_content")
<div class="report-container" style="overflow: hidden;">
    <div class="report-header clearfix">
        <div class="animated fadeInLeft left">
            <div class="icon">
                <img src="/themes/{{ $shop_theme }}/img/report-icon.png">
            </div>
            <div class="text">
                <div class="name">Credits</div>
                <!-- <div class="sub">. </div> -->
            </div>
        </div>
    </div>
    
    <h3 class="animated slideInDown text-center">Available Credits</h3>
<!--     <button class="btn btn-custom product-add-cart" item-id="2708" quantity="1" style="opacity: 1;">ENROLL NOW</button> -->
    
    <div class="report-content">
        <div class="animated fadeInUp holder">
            <div class="row clearfix">
                @foreach($_item as $item)
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="item-redeemable">
                            <div class="image-container match-height">
                                <img src="">
                            </div>
                            <div class="item-name"><h4><b>{{$item->item_name}}</b></h4></div>
                            <div class="item-name"><h4><b> </b></h4></div>
                            <div class="bottom-text"><label>{{number_format($item->item_price,2)}} PHP</label></div>
                            <div class="bottom-text"><button class="btn btn-brown product-add-cart" item-id="{{$item->item_id}}" quantity="1">Purchase</button></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <hr>
</div>
@endsection
@section("member_script")
<script type="text/javascript">
$(".purchase-credits-btn").click(function()
{
    alert(321);
});
</script>
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/report.css">
@endsection