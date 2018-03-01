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
        	margin: 0;
        	padding: 0;
        }
		    table {
		    font-family: arial, sans-serif;
		    border-collapse: collapse;
		    width: 100%;
        margin-bottom: 0;
		    page-break-inside: avoid; 
		    margin-top: 0;
		    margin-left: 0;
		    margin-right: 0;
		}

		td {
		    border: 1px solid #dddddd;
		    text-align: center;
		    padding: 0px;
		    font-size: 7px;
		    page-break-inside: avoid;
		}
		th {
		    border: 1px solid #dddddd;
		    text-align: center;
    padding-top: 8px;
		    font-size: 10px;
		    page-break-inside: avoid;
		}

    ul{
      margin: 0;
      display: inline-block;
      page-break-inside: avoid;
      margin-bottom: 200px;
    }
    li{
      list-style-type: none;
      font-size: 12px;
      margin: 0;
      page-break-inside: avoid;
    }

          /*div.breakNow { page-break-inside:avoid; page-break-after:always; }*/
        </style>
    </head>
    <body>

			@foreach($_employee as $key => $employee)
      <div class="tablecontainer">
			<table>
				  <tr>
				    <th width="15%"><br>{{ $employee->payroll_employee_number }}</th>
				    <th width="48%"><br>{{ $employee->payroll_employee_last_name }}, {{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }}</th>
				    <th width="30%"><br>{{ $show_period_start }} - {{ $show_period_end }}</th>
				    <th width="17%"><br>@if($show_release_date != 'not specified') {{ $show_release_date }}
                        @endif</th>
				  </tr>
                      <tr>
                      <td style="font-weight: bold;">{{ $employee->payroll_employee_last_name }}, {{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }}</td>
                      <td></td>
                      <td style="font-weight: bold;">{{ $employee->payroll_employee_last_name }}, {{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }}</td>
                      <td></td>
                   </tr>
				   <tr>

                      <td style="font-weight: bold;">BASIC PAY</td>
                      <td style="font-weight: bold">{{ payroll_currency($employee->net_basic_pay) }}</td>
                      <td style="font-weight: bold">BASIC PAY</td>
                       <td style="font-weight: bold">{{ payroll_currency($employee->net_basic_pay) }}</td>
                   </tr>
                 @foreach($employee->cutoff_breakdown->_gross_pay_breakdown as $breakdown)
                    @if(strtoupper($breakdown["label"]) != 'COLA')
                      <tr>
                          <td>{{ strtoupper($breakdown["label"]) }}</td>
                          <td>{{ payroll_currency($breakdown["amount"]) }}</td>
                          <td>{{ strtoupper($breakdown["label"]) }}</td>
                           <td>{{ payroll_currency($breakdown["amount"]) }}</td>
                      </tr>
                    @else
                    @endif
                  @endforeach
{{-- 
                              <tr>
                                  <td></td>
                                  <td style="font-weight: bold;">GROSS SALARY</td>
                                  <td style="font-weight: bold">{{ payroll_currency($employee->gross_pay) }}</td>
                                   <td ></td>
                               </tr> --}}

                  @foreach($employee->cutoff_breakdown->_taxable_salary_breakdown as $breakdown)
                                    @if($breakdown["add.gross_pay"] == true && $breakdown["deduct.taxable_salary"] == true && $breakdown["add.net_pay"] == true)
                                    @else
                                      <tr>
                                          <td>{{ strtoupper($breakdown["label"]) }}</td>
                                          <td >{{ payroll_currency($breakdown["amount"]) }}</td>
                                          <td>{{ strtoupper($breakdown["label"]) }}</td>
                                           <td >{{ payroll_currency($breakdown["amount"]) }}</td>
                                      </tr>
                                    @endif
                    @endforeach


                      @foreach($employee->cutoff_breakdown->_net_pay_breakdown as $breakdown)
                                    @if($breakdown["add.gross_pay"] == true && $breakdown["deduct.taxable_salary"] == true && $breakdown["add.net_pay"] == true)
                                    @else
                                      <tr>
                                          <td>{{ strtoupper($breakdown["label"]) }}</td>
                                          <td >{{ payroll_currency($breakdown["amount"]) }}</td>
                                          <td >{{ strtoupper($breakdown["label"]) }}</td>
                                           <td >{{ payroll_currency($breakdown["amount"]) }}</td>
                                      </tr>
                                    @endif
                    @endforeach


                                  <tr>
                                      <td>TOTAL DEDUCTION</td>
                                      <td>{{ payroll_currency($employee->total_deduction) }}</td>
                                       <td>TOTAL DEDUCTION</td>
                                        <td >{{ payroll_currency($employee->total_deduction) }}</td>
                                  </tr> 

                                  <tr>
                                      <td style="font-weight: bold;">TAKE HOME PAY</td>
                                      <td style="font-weight: bold">{{ payroll_currency($employee->net_pay) }}</td>
                                       <td style="font-weight: bold">TAKE HOME PAY</td>
                                        <td style="font-weight: bold">{{ payroll_currency($employee->net_pay) }}</td>
                                  </tr>


			</table>
    </div>
{{--         <ul>
          <li>BASIC PAY : &nbsp; {{ payroll_currency($employee->net_basic_pay) }}</li>
          @foreach($employee->cutoff_breakdown->_gross_pay_breakdown as $breakdown)
              <li>{{ strtoupper($breakdown["label"]) }} : &nbsp; {{ payroll_currency($breakdown["amount"]) }}</li>
          @endforeach
        </ul> --}}

    {{--     <ul>
          <li>GROSS SALARY : &nbsp; {{ payroll_currency($employee->gross_pay) }}</li>
        </ul> --}}
			@endforeach

    </body>
</html>

