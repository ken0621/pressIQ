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
    <link rel="stylesheet" href="/assets/initializr/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/initializr/css/bootstrap-theme.min.css">
    <!--<link rel="stylesheet" href="/assets/initializr/css/main.css">-->
    {{-- <link rel="stylesheet" href="/assets/front/css/global.css"> --}}
</head>
<body>
    <div style="vertical-align: top;">
        <div class="row" style="margin-top: 10px;">
            <div class="col-md-6 text-center">
                <div>
                    <img src="{{ $employee_company->payroll_company_logo }}" class="rounded float-right" alt="{{ $employee_company->payroll_company_name }}" height="150" width="150">
                </div>
             </div>
            <div class="col-md-6" >
                <div> </div>
                <div style="font-weight: bold; font-size: 22px; text-transform:uppercase;">{{ $employee_company->payroll_company_name }}</div>
                <div style="font-weight: bold; font-size: 20px;">{{ $period_record->payroll_employee_display_name }}</div>
                <div style="font-weight: font-size: 16px;">{{ date('M d, Y',strtotime($period_record->payroll_period_start))." - ".date('M d, Y',strtotime($period_record->payroll_period_end)) }}</div>
                <div style="font-weight: font-size: 16px;">{{ "Release Date: ".date('M d, Y',strtotime($period_record->payroll_release_date)) }}</div>
            </div>
        </div>
        <br>
        <div class="clearfix">   
            <div class="col-md-12">
                <div class="payslip-wrapper page">
                    <div class="main-content-holder">
                            <div class="row" >
                                <div class="col-md-12 pull-left" style="font-weight: bold; font-size: 18px;">
                                    SALARY COMPUTATION
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table style="width: 100%;" class="table table-bordered">
                                    <tbody>
                                    
                                        <tr>
                                            <td width="40%" style="font-weight: bold;">BASIC PAY</td>
                                            <td width="30%" style="font-weight: bold;" class="text-right">{{ payroll_currency($period_record->net_basic_pay) }}</td>
                                            <td width="30%" style="font-weight: bold;"></td>
                                        </tr>
                                        
                                        <!-- ADDITION TO GET GROSS -->
                                        @foreach($period_record->cutoff_breakdown->_gross_pay_breakdown as $breakdown)
                                        <tr>
                                            <td>{{ strtoupper($breakdown["label"]) }}</td>
                                            <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                        
                                        <tr style="font-weight: bold;">
                                            <td style="font-weight: bold;">GROSS SALARY</td>
                                            <td style="font-weight: bold;"></td>
                                            <td style="font-weight: bold;" class="text-right">{{ payroll_currency($period_record->gross_pay) }}</td>
                                        </tr>

                                        @foreach($period_record->cutoff_breakdown->_taxable_salary_breakdown as $breakdown)
                                        @if($breakdown["add.gross_pay"] == true && $breakdown["deduct.taxable_salary"] == true && $breakdown["add.net_pay"] == true)
                                        @else
                                        <tr>
                                            <td>{{ strtoupper($breakdown["label"]) }}</td>
                                            <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
                                            <td></td>
                                        </tr>
                                        @endif
                                        @endforeach

                                        @foreach($period_record->cutoff_breakdown->_net_pay_breakdown as $breakdown)
                                        @if($breakdown["add.gross_pay"] == true && $breakdown["deduct.taxable_salary"] == true && $breakdown["add.net_pay"] == true)
                                        @else
                                        <tr>
                                            <td>{{ strtoupper($breakdown["label"]) }}</td>
                                            <td class="text-right">{{ payroll_currency($breakdown["amount"]) }}</td>
                                            <td></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        
                                        <tr>
                                            <td>TOTAL DEDUCTION</td>
                                            <td></td>
                                            <td class="text-right">{{ payroll_currency($period_record->total_deduction) }}</td>
                                        </tr>

                                        <tr style="font-weight: bold;">
                                            <td style="font-weight: bold;">TAKE HOME PAY</td>
                                            <td style="font-weight: bold;"></td>
                                            <td style="font-weight: bold;" class="text-right">{{ payroll_currency($period_record->net_pay) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row" >
                                <div class="col-md-12 pull-left" style="font-weight: bold; font-size: 18px;">
                                    PERFORMANCE SUMMARY
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table style="width: 100%;" class="table table-bordered">
                                    <tbody>
                                    @foreach($period_record->cutoff_breakdown->_time_breakdown as $key => $time_breakdown)
                                      <tr>
                                          <td style="text-transform:uppercase">{{ str_replace("_"," ",$key) }}</td>
                                          <td class="text-right">{{ $time_breakdown["time"] }}</td>
                                      </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</body>
</html>