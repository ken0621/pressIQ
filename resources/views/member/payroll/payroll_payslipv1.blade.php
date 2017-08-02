<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Digima House</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <link rel="stylesheet" href="/assets/initializr/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/initializr/css/bootstrap-theme.min.css">
        <!--<link rel="stylesheet" href="/assets/initializr/css/main.css">-->
        <link rel="stylesheet" href="/assets/front/css/global.css">
        <style type="text/css">
          td
          {
            padding: 5px;
            font-size: 11px;
          }


          div.breakNow { page-break-inside:avoid; page-break-after:always; }
        </style>
    </head>
    <body>

    <div style="vertical-align: top; text-align: center;">
        @foreach($_employee as $key => $employee)
        <div class="payslip-wrapper page" style="width: 46%; padding: 10px; border: 1px solid #bbb; display: inline-block; vertical-align: top; top: 0; background-color: #fff; float: left; margin: 5px;">
            <div class="main-content-holder">
              <div class="row" >
                <div class="col-md-12 text-center" style="font-weight: bold; font-size: 16px;">{{ strtoupper($company->payroll_company_name) }}</div>
                <div style="margin-top: 10px;">
                    <div class="col-md-6">{{ $employee->payroll_employee_last_name }}, {{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }}</div>
                    <div class="col-md-6">{{ $show_period_start }} - {{ $show_period_end }}</div>
                </div>
              </div>

              <div class="row" style="margin-top: 20px; text-align: left;">
                  <div class="col-md-12">
                      <table style="width: 100%;" class="table table-bordered">
                          <tbody>
                              <tr >
                                  <td width="40%" style="font-weight: bold;">BASIC PAY</td>
                                  <td width="30%" style="font-weight: bold;" class="text-right">{{ payroll_currency($employee->net_basic_pay) }}</td>
                                  <td width="30%" style="font-weight: bold;"></td>
                              </tr>

                              <!-- ADDITION TO GET GROSS -->
                              @foreach($employee->cutoff_breakdown->_gross_pay_breakdown as $breakdown)
                              <tr>
                                  <td>{{ strtoupper($breakdown["label"]) }}</td>
                                  <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
                                  <td></td>
                              </tr>
                              @endforeach

                              <tr style="font-weight: bold;">
                                  <td style="font-weight: bold;">GROSS SALARY</td>
                                  <td style="font-weight: bold;"></td>
                                  <td style="font-weight: bold;" class="text-right">{{ payroll_currency($employee->gross_pay) }}</td>
                              </tr>

                              @foreach($employee->cutoff_breakdown->_taxable_salary_breakdown as $breakdown)
                              <tr>
                                  <td>{{ strtoupper($breakdown["label"]) }}</td>
                                  <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
                                  <td></td>
                              </tr>
                              @endforeach



                              @foreach($employee->cutoff_breakdown->_net_pay_breakdown as $breakdown)
                              <tr>
                                  <td>{{ strtoupper($breakdown["label"]) }}</td>
                                  <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
                                  <td></td>
                              </tr>
                              @endforeach


                              <tr>
                                  <td>TOTAL DEDUCTION</td>
                                  <td></td>
                                  <td class="text-right">{{ payroll_currency($employee->total_deduction) }}</td>
                              </tr>

                              <tr style="font-weight: bold;">
                                  <td style="font-weight: bold;">TAKE HOME PAY</td>
                                  <td style="font-weight: bold;"></td>
                                  <td style="font-weight: bold;" class="text-right">{{ payroll_currency($employee->net_pay) }}</td>
                              </tr>

                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
        </div>
          @if(($key+1)%4 == 0)
            <div class="breakNow"></div>
          @endif
        @endforeach


    </div>

    </body>
</html>