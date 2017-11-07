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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                        <li class="{{ (Request::segment(2)=='') ? 'active' : ''  }}"><a href="/employee">Dashboard<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
                        <li class="{{ (Request::segment(2) == 'Company Details') ? 'active' : ''  }}"><a href="/company_details">Company Details<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
                        <li class="{{ (Request::segment(2) == 'Profile') ? 'active' : ''  }}"><a href="/employee_profile">Profile<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
                        <li class="{{ (Request::segment(2) == 'Profile') ? 'active' : ''  }}"><a href="/employee_leave_management">Leave Management<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-calendar"></span></a></li>
                        <li class="{{ (Request::segment(2) == 'message') ? 'active' : ''  }}"><a href="/employee_overtime_management">Over Time Management<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-time"></span></a></li>
                        <li class="{{ (Request::segment(2) == 'message') ? 'active' : ''  }}"><a href="/employee_official_business_management">Official Business Management<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-road"></span></a></li>
                        <li class="{{ (Request::segment(2) == 'message') ? 'active' : ''  }}"><a href="/employee_official_business">RFP<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
                        <li class="dropdown">
                            <a href="/" class="dropdown-toggle" data-toggle="dropdown">Authorization Access<span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-cog"></span></a>
                            <ul class="dropdown-menu forAnimate" role="menu">
                                <li><a href="/authorization_access_leave">Leave</a></li>
                                <li><a href="/authorization_access_over_time">Over Time</a></li>
                                <li><a href="/authorization_access_official_business">Official Business</a></li>
                            </ul>
                        </li>
                        <li class="{{ (Request::segment(2) == 'message') ? 'active' : ''  }}"><a href="/employee_official_business">Reports<span style="font-size:16px;" class="pull-right hidden-xs showopacity"></span></a></li>
                        <li class="{{ (Request::segment(2) == 'message') ? 'active' : ''  }}"><a href="/employee_login">Logout<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-off"></span></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--     <ul class="nav navbar-nav navbar-right">
            <li class="dropdown"><a data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="#">Page 1-1</a></li>
                <li><a href="#">Page 1-2</a></li>
                <li><a href="#">Page 1-3</a></li>
            </ul>
        </li>
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
    -->
    <div class="main">
        @yield("content")
        <!-- Content Here -->
    </div>
</body>
</html>