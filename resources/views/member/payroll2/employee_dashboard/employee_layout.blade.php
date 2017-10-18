<!DOCTYPE html>
<html lang="en">
<head>
    <title>DIGIMAHOUSE | {{ $page }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/initializr/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/assets/initializr/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="/assets/initializr/js/vendor/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/assets/employee.css">
    <script src="/assets/employee.js"></script>


</head>
<body>

<nav class="navbar navbar-inverse sidebar" role="navigation">
    <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="iconb-ar"></span>
      </button>
      <a class="navbar-brand" href="#">DIGIMAHOUSE</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ (Request::segment(2)=='')          ? 'active' : ''  }}"><a href="/employee">Home<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
        <li class="{{ (Request::segment(2) == 'profile') ? 'active' : ''  }}"><a href="/employee_profile">Profile<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
        <li class="{{ (Request::segment(2) == 'message') ? 'active' : ''  }}"><a href="/employee_leave_application">Leave Application<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-pencil"></span></a></li>
        <li class="{{ (Request::segment(2) == 'message') ? 'active' : ''  }}"><a href="/employee_summary_of_leave">Summary of Leave<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-list-alt"></span></a></li>
        <li class="{{ (Request::segment(2) == 'message') ? 'active' : ''  }}"><a href="/employee_logout">Logout<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-off"></span></a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="main">
 @yield("content")
<!-- Content Here -->
</div>

</body>
</html>