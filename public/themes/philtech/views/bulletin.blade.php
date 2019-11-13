@extends("layout")
@section("content")
<div class="container">
    <div class="announcement-container" style="text-align: center; height: 100vh; display: flex; align-items:center; justify-content: center; padding: 25px;">
        <div style="max-width: 700px; margin-right: 10px;">
            <img src="/themes/{{ $shop_theme }}/img/announcement-1.jpg" alt="" style="width: 100%;">
        </div>
        <div style="max-width: 700px;">
            <img src="/themes/{{ $shop_theme }}/img/announcement-3.jpg" alt="" style="width: 100%;">
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/aboutus.css">
@endsection
