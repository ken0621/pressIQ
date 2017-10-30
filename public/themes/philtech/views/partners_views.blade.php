@extends("layout")
@section("content")
<div class="content">
   <div class="container">
        <div class="single-slide">
        @foreach($_company as $cm)
            <div class="merchant-wrapper">
                <div class="controls-container">
                    <p>{{strtoupper($cm->company_name)}}</p>
                    <div class="prev"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i></div>
                    <div class="next"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></div>
                </div>
                <div class="merchant-img-container">
                    <img src="{{$cm->company_brochure}}">
                </div>
                <br>
                <br>
                <br>
                <div class="map-address text-center">
                    <h4><strong>{{$cm->company_address}}</strong></h4>
                </div>
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCRvE3JLUuCDLRdqAz4ngx61tQDImQjOxQ&q={{$cm->company_address}}" width="600" height="450" frameborder="0" style="border:0" frameborder="0"></iframe>
                </div>
            </div>
        @endforeach
        </div>
        <div class="merchant-wrapper">
            <div class="controls-container">
                <p>{{strtoupper($company->company_name)}}</p>
                <div class="prev"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i></div>
                <div class="next"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></div>
            </div>
            <div class="merchant-img-container">
                <img src="{{$company->company_brochure}}">
            </div>
            <br>
            <br>
            <br>
            <div class="map-address text-center">
                <h4><strong>{{$company->company_address}}</strong></h4>
            </div>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCRvE3JLUuCDLRdqAz4ngx61tQDImQjOxQ&q={{$company->company_address}}" width="600" height="450" frameborder="0" style="border:0" frameborder="0"></iframe>
            </div>
        </div>
    </div>    
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/partners_views.css">
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.single-slide').slick({
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          speed: 500,
          fade: true,
          cssEase: 'linear'
        });

        $(".prev").click(function()
        {
            alert(123);
        });
    });
</script>
@endsection

