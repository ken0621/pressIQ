@extends('mlm.layout')
@section('content')
<style type="text/css">
.newsimage
{
    width: 100%;
    height: 250px;
    min-height: 250px;
    max-height: 250px;
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<div class="row">
    <div class="col-md-6 col-lg-8">
        <div class="cover-holder panel panel-default panel-block panel-title-block">
            <div class="panel-headings clearfix">
                <img class="banner-img" src="/assets/mlm/img/banner-shop.jpg">
                <div class="shadow">
                    <img src="/assets/mlm/img/shadow.png">
                </div>
                <div class="cover-container">
                    <div class="cover-img">
                        <img src="{{isset($content['company_logo']) ? $content['company_logo'] : '/assets/mlm/img/pic-shop.jpg'}}" width="200px">
                    </div>
                    <div class="cover-text">
                        <div class="name">@if(isset($content['company_name']))  {{$content['company_name']}} @endif</div>
                        <div class="date hide">This account is a member since June 03, 2015 - 11:09 PM</div>
                        <div class="email"><span class="hide">>@if(isset($content['company_email']))  {{$content['company_email']}} @endif</span><hr></div>

                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="tab-content panel panel-default panel-block">
            <!-- OVERVIEW -->
            <div style="" class="tab-pane <?php echo (!isset($_GET["tab"]) && !isset($_GET["tabpw"]) && !Request::input('gc')  && !Request::input('wallet') ? "active" : ""); ?>" id="user-overview">   
                {!! $income !!}
            </div>
        </div> 
    </div>
  {!! $news !!}
</div>
@endsection
@section('js')
<script type="text/javascript" src="/resources/assets/toaster/toastr.min.js"></script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/assets/mlm/css/dashboard.css">
@endsection