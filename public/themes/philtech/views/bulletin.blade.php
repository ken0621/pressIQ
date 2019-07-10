@extends("layout")
@section("content")
<div class="container">
    <div class="bulletin-container" style="text-align: center; height: 100vh; display: flex; align-items:center; justify-content: center; padding: 25px;">
        <div>
            <img src="/themes/{{ $shop_theme }}/img/fcking-bulletin.jpg" alt="" style="width: 100%;">
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/aboutus.css">
@endsection
