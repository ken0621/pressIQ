<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>Digima | Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/admin_assets/new_css/additonal.css">
  <link rel="stylesheet" href="/admin_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/admin_assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/admin_assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- GOOGLE FONT -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700" rel="stylesheet">     
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
  @import url('https://fonts.googleapis.com/css?family=Lato:300,400');
  html, body 
  {
  font-family: 'Lato', serif;  
  }
  </style>
</head>
  <body class="put-here">
  <nav class="navbar navbar-default">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <a class="navbar-brand" href="#" style="color:white;">Digima Admin</a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="" data-toggle="modal" data-target="#myModal" id="loginbtn" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Log in</a>
          </li>
           <li class="dropdown">
            <a href="#" data-toggle="modal" data-target="#myModal1" id="signupbtn" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Sign Up</a>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
  </nav>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <div class="item active">
          <img class= "background-carousel" src="/themes/digimahouse_landingpage/img/img-slider-1.png" alt="Los Angeles">
          <div class="container text">
            <div class="carousel-caption">
            <h3 class= "p1" style ="white-space: nowrap"><b>Digima House ERP Online</b></h3>
            <p class = "p2" style="white-space: nowrap"><b>A house built for your business</b></p>
            <br>
            <p class = "p3"><b>Our goal is to provide</b></p>
            <p class = "p3"><b>and build professional websites,</b></p>
            <p class = "p3"><b> mobile applications that best </b></p>
            <p class = "p3"><b> suit to your business.</b></p>
          </div>
        </div> 
      </div>
    </div> 
  </div>
  </body>      
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <div class="copyright">
            Digima Web Solutions
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <div class="design">
          Web Design and Development by Digimahouse
          </div>
        </div>
      </div>
    </div>
  </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="padding:35px 50px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
          </div>
          <div class="modal-body" style="padding:40px 50px;">
            <form class = "login" role="form" method="post" action="/admin/login">
               <input type="hidden"  class="_token" id="_token" value="{{csrf_token()}}"/>
              {{csrf_field()}}
             @if(session('message'))
              <div style="color: red;">{{ session('message') }}</div>
            @endif
              <div class="form-group">
                <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
                <input type="text"  class="form-control" id="usrname" name="username" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
                <input type="password"  class="form-control" id="psw" name="password" placeholder="Enter password">
              </div>
                <button type="submit" id ="login" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
            </form>
          </div>
        </div> 
      </div>
    </div> 
    <div class="modal fade" id="myModal1" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="padding:35px 50px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4><span class="glyphicon glyphicon-user"></span> Sign Up</h4>
          </div>
          <div class="modal-body" style="padding:40px 50px;">
            <form role="form" method="post" action="/admin/signup" enctype="multipart/form-data">
            <input type="hidden"  class="_token1" id="_token1" value="{{csrf_token()}}"/>
              {{ csrf_field() }}
              <div class="form-group">
                <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
                <input type="text" class="form-control" id="usrname" name="username" placeholder="Enter email"
                minlength="5" required>
              </div>
              <div class="form-group">
                <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
                <input type="password" class="form-control" id="psw" name="password" placeholder="Enter password">
              </div>
              <div class="form-group">
                <label for="first_name"><span class="glyphicon glyphicon-user"></span> First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First name">
              </div>
              <div class="form-group">
                <label for="last_name"><span class="glyphicon glyphicon-user"></span> Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name">
              </div>
              <div class="form-group">
                <label for="mobile_number"><span class="glyphicon glyphicon-phone"></span> Mobile Number</label>
                <input type="Number" class="form-control" id="mobile_number" name= "mobile_number" placeholder="Enter Mobile Number">
              </div>
              <div class="form-group">
                <label for="img"><span class="glyphicon glyphicon-user"></span> Profile Picture</label>
                <input type="file" class="form-control" id="user_pic" name= "user_pic">
              </div>
                <button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok sample"></span>  Sign Up</button>
            </form>
          </div>
        </div>
        
      </div>
    </div> 
  </div>
<script src="/admin_assets/js/login.js"></script>
<!-- jQuery 3 -->
<script src="/admin_assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/admin_assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/admin_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</html>
