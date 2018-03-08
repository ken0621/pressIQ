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
    <!-- <link rel="apple-touch-icon" href="apple-touch-icon.png"> -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!--<link rel="stylesheet" href="/assets/initializr/css/main.css">-->
    {{-- <link rel="stylesheet" href="/assets/front/css/global.css"> --}}

    <style type="text/css">
    html{
        margin:100 100px;
      /*div.breakNow { page-break-inside:avoid; page-break-after:always; }*/
    }
    h1 {
        color:#585858;
        font-size: 40px;
        font-weight: 650px;
    }
    .period {
        width: 100%;
        height: 50px;
        border-top:1px solid gray;
        border-bottom:1px solid gray;
        padding: 5px;
    }
    .left {
        float:left;
        height: 100%;
        width: 280px;
        border-right:1px solid gray;
    }
    .right {
        float:left;
        height: 100%;
        width: 436px;
    }
    .employee {
        height: 150px;
        width: inherit;
        padding: 20px;
    }
     .contri {
        height: 150px;
        width: inherit;

    }
     .yeartodate {
        height: 350px;
        width: inherit;
    }
    </style>
</head>
<body>
    @php
    $att = 1;
    @endphp
    <h1>Payslip</h1>
    <div class="period">
        <div class="header">
            <div class="sa" style="width:230px;text-align: center;float:left;font-size: 14px;color:#383838;">
                RELEASE DATE
            </div>
            <div class="sa" style="width:230px;text-align: center;float:left;font-size: 14px;color:#383838;">
                PAYROLL PERIOD
            </div>
            <div class="sa" style="width:230px;text-align: center;float:left;font-size: 14px;color:#383838;">
                DAYS WORK
            </div>
                  <div class="sa" style="width:230px;text-align: center;float:left;font-size: 14px;color:#383838;font-weight: bold;">
                {{$period_record_release_date}}
            </div>
            <div class="sa" style="width:230px;text-align: center;float:left;font-size: 14px;color:#383838;font-weight: bold;">
                {{$period_record_start}} - {{$period_record_end}}
            </div>
            <div class="sa" style="width:230px;text-align: center;float:left;font-size: 14px;color:#383838;font-weight: bold;">
                @foreach($period_record->cutoff_breakdown->_time_breakdown as $key => $time)
                    @if($att == 1)
                        {{$time["float"]}} Days
                    @endif
                     @php
                        $att++;
                      @endphp
                @endforeach
            </div>
        </div>
    </div>
    <div class="left">
        <div class="employee">
            <h4 style="color:#585858;font-weight: bold;text-align: center;">{{$period_record->payroll_employee_display_name}}</h4>

         <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                Employee ID
        </div>
         <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                {{$period_record->payroll_employee_number}}
        </div>
          <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                Gender
        </div>
         <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold;">
               {{$period_record->payroll_employee_gender}}
        </div>
          <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                Date Hired
        </div>
         <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
 
        </div>
        </div>

        <div class="contri">
            <h4 style="color:#585858;font-weight: bold;text-align: center;margin: 0;">Employer Contribution</h4>
            <hr>
                    <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                        SSS ER
                    </div>
                     <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                           {{$period_record->sss_er}}
                    </div>
                    <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                        SSS EC
                    </div>
                     <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                           {{$period_record->sss_ec}}
                    </div>
                    <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                        PHILHEALTH ER
                    </div>
                     <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                           {{$period_record->philhealth_er}}
                    </div>
                    <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                        PAGIBIG ER
                    </div>
                     <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                           {{$period_record->pagibig_er}}
                    </div>


        </div>

        <div class="yeartodate">
            <h4 style="color:#585858;font-weight: bold;text-align: center;margin: 0;">Year to Date Summary</h4>
            <hr>
         <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                Gross Salary
            </div>
             <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                    {{$total_gross_pay}}
            </div>
                 <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                Taxable Income
            </div>
             <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                    {{$total_tax_pay}}
            </div>
                 <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                Withholding Tax
            </div>
             <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                    {{$total_tax_ee}}
            </div>
                 <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                Net Pay
            </div>
             <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                    {{$total_net_pay}}
            </div>
            <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                SSS Employer
            </div>
             <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                    {{$total_sss_ee}}
            </div>
                 <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                Philhealth Employer
            </div>
             <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                    {{$total_philhealth_ee}}
            </div>
            <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
                Pagibig Employer
            </div>
             <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
                    {{$total_pagibig_ee}}
            </div>
        </div>
    </div>

    <div class="right">
        <br>
        <br>
        <div class="line" style="height: 1px;background-color: #909090;width: 100%;">
        </div>
            <div class="sa" style="width:50%;text-align: center;float:left;color:#383838;margin-bottom: 5px;font-size:13px;font-weight: bold;">
                BASIC SALARY
            </div>
            <div class="sa" style="width:50%;text-align: center;float:left;color:#383838;margin-bottom: 5px;font-weight: bold;font-size: 13px;">
                {{ payroll_currency($period_record->net_basic_pay) }}
            </div>
        <div class="line" style="height: 1px;background-color: #909090;width: 100%;">
      </div>
      <br>
     @foreach($period_record->cutoff_breakdown->_gross_pay_breakdown as $breakdown)
        <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
            {{ strtoupper($breakdown["label"]) }}
        </div>
        <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
            {{ payroll_currency($breakdown["amount"]) }}
        </div>
      @endforeach 
      <br>
      <div class="line" style="height: 1px;background-color: #909090;width: 100%;">
      </div>
        <div class="sa" style="width:50%;text-align: center;float:left;color:#383838;margin-bottom: 5px;font-size:13px;font-weight: bold;">
            GROSS SALARY
        </div>
        <div class="sa" style="width:50%;text-align: center;float:left;color:#383838;margin-bottom: 5px;font-weight: bold;font-size: 13px;">
            {{ payroll_currency($period_record->gross_pay) }}
        </div>
    <div class="line" style="height: 1px;background-color:  #909090;width: 100%;">
      </div>
      <br>


        @foreach($period_record->cutoff_breakdown->_taxable_salary_breakdown as $breakdown)
        @if($breakdown["add.gross_pay"] == true && $breakdown["deduct.taxable_salary"] == true && $breakdown["add.net_pay"] == true)
        @else
      <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
            {{ strtoupper($breakdown["label"]) }}
        </div>
        <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
            {{ payroll_currency($breakdown["amount"]) }}
        </div>
        @endif
        @endforeach


   @foreach($period_record->cutoff_breakdown->_net_pay_breakdown as $breakdown)
        @if($breakdown["add.gross_pay"] == true && $breakdown["deduct.taxable_salary"] == true && $breakdown["add.net_pay"] == true)
        @else
     <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;">
            {{ strtoupper($breakdown["label"]) }}
        </div>
        <div class="sa" style="width:50%;text-align: center;float:left;font-size: 12px;color:#383838;margin-bottom: 5px;font-weight: bold">
            {{ payroll_currency($breakdown["amount"]) }}
        </div>
          @endif

    @endforeach
    <br>
        <div class="line" style="height: 1px;background-color:  #909090;width: 100%;">
      </div>
      <div class="sa" style="width:50%;text-align: center;float:left;color:#383838;margin-bottom: 5px;font-size:13px;font-weight: bold;">
            TOTAL DEDUCTION
        </div>
        <div class="sa" style="width:50%;text-align: center;float:left;color:#383838;margin-bottom: 5px;font-weight: bold;font-size: 13px;">
            {{ payroll_currency($period_record->total_deduction) }}
        </div>

        <div class="sa" style="width:50%;text-align: center;float:left;color:#383838;margin-bottom: 5px;font-size:13px;font-weight: bold;">
            TAKE HOME PAY
        </div>
        <div class="sa" style="width:50%;text-align: center;float:left;color:#383838;margin-bottom: 5px;font-weight: bold;font-size: 13px;">
            {{ payroll_currency($period_record->net_pay) }}
        </div>
        <div class="line" style="height: 1px;background-color:  #909090;width: 100%;">
      </div>

    </div>

</body>
</html>