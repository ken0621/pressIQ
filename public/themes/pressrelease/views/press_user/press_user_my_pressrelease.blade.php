@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="my-press-release-container">
        	<div class="title-container"><a href="/pressuser/mypressrelease/pressrelease/view">Press Release 1</a></div>
        	<div class="date-container">November 25, 2017</div>
        	<div class="details-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. sed do eiusmod tempor incididunt ut labore</div>
        	<div class="border"></div>
        	<div class="title-container"><a data-toggle="tab" href="#">Press Release 2</a></div>
        	<div class="date-container">November 25, 2017</div>
        	<div class="details-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. sed do eiusmod tempor incididunt ut labore</div>
        	<div class="border"></div>
        	<div class="title-container"><a data-toggle="tab" href="#">Press Release 3</a></div>
        	<div class="date-container">November 25, 2017</div>
        	<div class="details-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. sed do eiusmod tempor incididunt ut labore</div>
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_my_pressrelease.css">
@endsection

@section("script")

@endsection