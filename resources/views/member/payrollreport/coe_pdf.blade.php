<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <base href="{{ URL::to('/') }}">
        <title>Digima House</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- <link rel="apple-touch-icon" href="apple-touch-icon.png"> -->
        <!--<link rel="stylesheet" href="/assets/initializr/css/main.css">-->
        {{-- <link rel="stylesheet" href="/assets/front/css/global.css"> --}}
        <style type="text/css">
        html {
        	page-break-inside: avoid; 
        }
        .container {
          page-break-inside: avoid; 
          height: : 600px;
          width: 600px;
          margin-left:50px;
          padding-top: 140px;
        }
        .break {
          page-break-inside: avoid; 
        }
        </style>
    </head>
    <body>

      @foreach($_employee as $employee)
      <div class="break">
      <img src="/var/www/html/digimahouse/public{{$employee->payroll_company_logo}}" style="max-height: 150px;">
      <div class="container">
        <h4 style="font-weight: regular;margin-bottom: 50px;">{{$date_today}}</h4>
        <h4 style="text-decoration: underline;text-align: center;letter-spacing: 2px;"><strong>CERTIFICATE OF EMPLOYEMENT</strong></h4>
        <p style="line-height: 25px;">This is to certify that @if($employee->payroll_employee_gender == "Male")
        He @else She @endif<span style="font-weight: bold;text-decoration: underline;">{{$employee->payroll_employee_display_name}}</span> was currently employed with <span style="font-weight: bold;text-decoration: underline;">{{$employee->payroll_company_name}}</span> since {{date("F j, Y",strtotime($employee->payroll_employee_contract_date_hired))}} up to present. @if($employee->payroll_employee_gender == "Male")
        He @else She @endif currently holds the position of <span style="font-weight: bold;text-decoration: underline;">{{$employee->payroll_jobtitle_name}}</span>.
This certification is being issued upon her request for whatever legal purpose it may serve her best.
        </p>
        <p>Issued at Makati City, Philippines. </p>

          <div class="jobtitle" style="width: 200px;margin-top: 80px;">
               <h5 style="text-decoration: underline;text-align: center;margin-bottom: 0px;"><strong>PRESIDENT</strong></h5>
            <h5 style="text-align: center;margin: 0 auto;font-weight: regular;">CEO</h5>
          </div>
      </div>
    </div>
      @endforeach

    </body>
</html>

