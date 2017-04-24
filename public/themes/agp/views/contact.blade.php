@extends('layout')
@section('content')
<div class="top_wrapper   no-transparent">
    <div class="header_page basic background_image" style="background-image:url(resources/assets/front/img/contact-bg.jpg);background-repeat: no-repeat; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; color:#2f383d; ">
        <div class="container">
            <h1 class="title">Contact <strong>Us</strong></h1>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="contact">
        <div class="container">
            <div class="lol-row clearfix">
                <div class="vc_col-sm-6 wpb_column column_container">
                    <div class="title">Get Intouch With Us</div>
                    <div class="lol-row clearfix">
                        <form method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="vc_col-sm-6 wpb_column column_container">
                                <input type="text" class="form-control" placeholder="First Name*">
                            </div>
                            <div class="vc_col-sm-6 wpb_column column_container">
                                <input type="text" class="form-control" placeholder="Last Name*">
                            </div>
                            <div class="vc_col-sm-6 wpb_column column_container">
                                <input type="text" class="form-control" placeholder="Phone Number*">
                            </div>
                            <div class="vc_col-sm-6 wpb_column column_container">
                                <input type="email" class="form-control" placeholder="Email Address*">
                            </div>
                            <div class="vc_col-sm-6 wpb_column column_container">
                                <input type="text" class="form-control" placeholder="Subject">
                            </div>
                            <div class="vc_col-sm-12 wpb_column column_container">
                                <textarea class="form-control" placeholder="Message"></textarea>
                            </div>
                            <div class="vc_col-sm-12 wpb_column column_container">
                                <button class="btn" type="submit">SEND</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="vc_col-sm-6 wpb_column column_container">
                    <div>
                        <div class="title">Location</div>
                        <div class="info">
                            <div class="holder"><img src="resources/assets/front/img/location-icon.png"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</div>
                            <div class="holder"><img src="resources/assets/front/img/mobile-icon.png"> +44 870 888 88 88</div>
                            <div class="holder"><img src="resources/assets/front/img/mail-icon.png"> youremail@here.com</div>
                        </div>
                    </div>
                    <div style="margin-top: 50px;">
                        <div class="title">Business Hours</div>
                        <div class="info">
                            <div class="holder"><img src="resources/assets/front/img/time-icon.png">  Monday - Friday at 9:00am - 6:00pm</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="resources/assets/front/css/contact.css">
@endsection