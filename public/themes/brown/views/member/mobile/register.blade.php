<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Brown</title>
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="{{$google_app_id or ''}}">
    <input type="hidden" name="" class="google_app_id" value="{{$google_app_id or ''}}">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/initializr/css/bootstrap.min.css">
    <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/initializr/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/initializr/css/main.css">
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/slick/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="/assets/member/css/loader.css">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/mobile/css/register.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/drawer.css">
    <!-- Brown Custom Icon -->
    <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/brown-icon/styles.css">
</head>
<body>
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div class="main-container clearfix">
        <div class="holder">
            <div class="lock">
                <img src="/themes/{{ $shop_theme }}/assets/mobile/img/lock.jpg">
                <div class="text">Already have an account?</div>
                <div class="right"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
            </div>
        </div>
        <div class="holder">
            <div class="form-group">
                <label>First Name</label>
                <input class="form-control" type="text" name="first_name" value="">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input class="form-control" type="text" name="last_name" value="">
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input class="form-control" type="date" name="birthday" value="">
            </div>
            <div class="form-group">
                <label>Country</label>
                <select class="form-control">
                    <option></option>
                </select>
            </div>
            <div class="form-group">
                <label>Permanent Address</label>
                <textarea class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select class="form-control">
                    <option></option>
                </select>
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input class="form-control" type="email" name="">
            </div>
            <div class="form-group">
                <label>Confirm E-mail</label>
                <input class="form-control" type="email" name="">
            </div>
            <div class="form-group">
                <label>TIN Number</label>
                <input class="form-control" type="number" name="tin" value="">
            </div>
            <div class="form-group">
                <label>Confirm TIN Number</label>
                <input class="form-control" type="number" name="tin" value="">
            </div>
            <div class="form-group">
                <label>Referror Upline</label>
                <input class="form-control" type="text" name="referror" value="">
            </div>
        </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="/themes/{{ $shop_theme }}/assets/initializr/js/vendor/bootstrap.min.js"></script>
</body>
</html>