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
		    page-break-inside: avoid !important; 
		    margin-top: 0;
		    margin-left: 0;
		    margin-right: 0;
	 	}

		td {
		    border: 1px solid #dddddd;
		    text-align: center;
		    padding: 0px;
		    font-size: 10px;
		    page-break-inside: avoid;
        font-weight: bold;
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
.div1 {
 height: 50px;
 width: 100px;
 float: left;
 page-break-inside: avoid;
}
          /*div.breakNow { page-break-inside:avoid; page-break-after:always; }*/
        </style>
    </head>
    <body>

		@foreach($_employee as $key => $employee)
          @php
          $dayswork = 1;
          $late = 1;
          $holiday = 1;
          $allowance = 1;
          $daysworks = 1;
          $holidays = 1;
          $additions = 0;
          $deductions = 0;
          $leave = 1;

          foreach($employee->cutoff_breakdown->_breakdown as $add)
          {
            if($add["type"] == 'additions')
            {
              $additions += $add["amount"];
            }
          }

          foreach($employee->cutoff_breakdown->_breakdown as $ded)
          {
            if($ded["type"] == 'deductions')
            {
              $deductions += $ded["amount"];
            }
          }
          @endphp
      <div class="tablecontainer">
      <table>
          <tr>
            <th width="15%" colspan="2"><br>{{ $employee->payroll_employee_number }}</th>
            <th width="48%" colspan="2" style="border-right-color: black;"><br>{{ $employee->payroll_employee_last_name }}, {{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }}</th>
            <th width="30%"><br>{{ $show_period_start }} - {{ $show_period_end }}</th>
            <th width="17%"><br>@if($show_release_date != 'not specified') {{ $show_release_date }}
                        @endif</th>
          </tr>

                    <tr>
                      <td style="font-weight: bold;"></td>
                      <td style=""></td>
                      <td style="font-weight: bold;"></td>
                      <td style="border-right-color: black;"></td>
                      <td>{{ $employee->payroll_employee_last_name }}, {{ $employee->payroll_employee_first_name }} {{ $employee->payroll_employee_middle_name }}</td>
                      <td></td>
                   </tr>
    </table>
<div class="div1">
  <table style="width:100%;float:left !important;margin: 0 !important;">
    <tr>
       <td>
          DAYS WORKED
       </td>
    </tr>
    <tr>
      <td>
         GROSS PAY
      </td>
    </tr>
    <tr>
       <td>
          LATES
        </td>
    </tr>
    <tr>
       <td>
          HOLIDAY PAY
       </td>
    </tr>
    <tr>
      <td>
          BASIC PAY
      </td>
    </tr>
    @foreach($employee->cutoff_breakdown->_taxable_salary_breakdown as $breakdown)
      @if($breakdown["type"] == 'government_contributions')
        <tr>
          <td>
            @if($breakdown["label"] == 'PHILHEALTH EE')
            PHILHEATH 
            @else 
             {{$breakdown["label"]}}
            @endif
          </td>
        </tr>
      @endif
    @endforeach
    <tr>
      <td>
        ALLOWANCE
      </td>
    </tr>
  </table>
</div>

<div class="div1">
  <table style="width:100%;float:left !important;margin: 0 !important;">
   @foreach($employee->cutoff_breakdown->_time_breakdown as $key => $time)
      <tr>
           @if($dayswork == 1)
           <td>{{ $time["float"]}}</td>
           @endif
      </tr>
          @php
            $dayswork++;
          @endphp
    @endforeach
      <tr>
        <td>
           {{ $employee->gross_pay }}
        </td>
      </tr>

     @foreach($employee->cutoff_breakdown->_breakdown as $breakdown)
          @if($breakdown["label"] == 'late')
              @if($late == 1)
                  <tr>
                    <td>
                       {{round($breakdown["amount"],2)}}
                    </td>
                  </tr>
                 @php
                    $late++;
                 @endphp
              @endif
          @endif
    @endforeach

    @if($late == 1)
      <tr>
        <td>-</td>
      </tr>
    @endif

    @foreach($employee->cutoff_breakdown->_breakdown as $breakdown)
          @if($breakdown["label"] == 'Special Holiday')
              @if($holiday == 1)
                  <tr>
                    <td>
                       {{round($breakdown["amount"],2)}}
                    </td>
                  </tr>
                 @php
                    $holiday++;
                 @endphp
              @endif
          @endif
    @endforeach

    @if($holiday == 1)
      <tr>
        <td>-</td>
      </tr>
    @endif


      <tr>
        <td>
            {{$employee->cutoff_breakdown->basic_pay_total }}
        </td>
      </tr>

    @foreach($employee->cutoff_breakdown->_taxable_salary_breakdown as $breakdown)
      @if($breakdown["type"] == 'government_contributions')
        <tr>
          <td>
             {{$breakdown["amount"]}}
          </td>
        </tr>
      @endif
    @endforeach

    @foreach($employee->cutoff_breakdown->_breakdown as $breakdown)
      @if(isset($breakdown["record_type"]))
          @if($breakdown["record_type"] == 'allowance')
              @if($allowance == 1)
                  <tr>
                    <td>
                       {{round($breakdown["amount"],2)}}
                    </td>
                  </tr>
                 @php
                    $allowance++;
                 @endphp
              @endif
          @endif
      @endif
    @endforeach

    @if($allowance == 1)
      <tr>
        <td>-</td>
      </tr>
    @endif

  </table>
</div>

<div class="div1">
    <table style="width:100%;float:left !important;margin: 0 !important;">
      @foreach($employee->cutoff_breakdown->_breakdown as $breakdown)
        @if($breakdown["type"] != 'government_contributions' && strtoupper($breakdown["label"]) != 'COLA' && $breakdown["label"] != 'absent' && $breakdown["label"] != 'undertime' && $breakdown["label"] != 'late')
          <tr>
              <td style="font-weight: bold;">
                  @if(isset($breakdown["record_type"]))
                    @if($breakdown["record_type"] != 'allowance')
                      @php
                      $exploded = explode( '-', $breakdown["label"]);
                      @endphp
                      {{strtoupper($exploded[0])}}
                    @endif
                  @else
                    {{ strtoupper($breakdown["label"]) }}
                  @endif
              </td>
          </tr>
        @endif
      @endforeach
      <tr>
        <td style="font-weight: bold;">
            TAKE HOME PAY
        </td>
      </tr>
    </table>
  </div>

<div class="div1">
      <table style="width:100%;display: inline-block;">
      @foreach($employee->cutoff_breakdown->_breakdown as $breakdown)
        @if($breakdown["type"] != 'government_contributions' && strtoupper($breakdown["label"]) != 'COLA' && $breakdown["label"] != 'absent' && $breakdown["label"] != 'undertime' && $breakdown["label"] != 'late')
          <tr>
              <td style="font-weight: bold;">
                @if(isset($breakdown["record_type"]))
                  @if($breakdown["record_type"] != 'allowance')
                   {{ strtoupper($breakdown["amount"]) }}
                  @endif
                @else
                   {{ strtoupper($breakdown["amount"]) }}
                @endif
              </td>
          </tr>
        @endif
      @endforeach
      <tr>
        <td style="font-weight: bold;">
            {{ $employee->net_pay }}
        </td>
      </tr>
    </table>
  </div>

    <div class="div1" style="width:40px !important;">
    <table style="width:100%;float:left !important;margin: 0 !important;">
      <tr>
        <td>
        </td>
      <tr>
    </table>
  </div>


  <div class="div1" style="width: 200px;">
  <table style="width:100%;float:left !important;margin: 0 !important;">
    <tr>
       <td>
          DAYS WORKED
       </td>
    </tr>
    <tr>
      <td>
         GROSS PAY
      </td>
    </tr>
    <tr>
       <td>
          HOLIDAY PAY
       </td>
    </tr>
    <tr>
      <td>
          BASIC PAY
      </td>
    </tr>
    <tr>
      <td>
          LEAVE PAY
      </td>
    </tr>
    @foreach($employee->cutoff_breakdown->_taxable_salary_breakdown as $breakdown)
      @if($breakdown["type"] == 'government_contributions')
        <tr>
          <td>
            @if($breakdown["label"] == 'PHILHEALTH EE')
            PHILHEATH 
            @else 
             {{$breakdown["label"]}}
            @endif
          </td>
        </tr>
      @endif
    @endforeach
    <tr>
        <td>
            ADDITIONS
        </td>
    </tr>
    <tr>
        <td>
            DEDUCTIONS
        </td>
    </tr>
    <tr>
        <td>
            TAKE HOME PAY
        </td>
    </tr>
  </table>
</div>

<div class="div1">
  <table style="width:100%;float:left !important;margin: 0 !important;">
   @foreach($employee->cutoff_breakdown->_time_breakdown as $key => $time)
      <tr>
           @if($daysworks == 1)
           <td>{{ $time["float"]}}</td>
           @endif
      </tr>
          @php
            $daysworks++;
          @endphp
    @endforeach
      <tr>
        <td>
           {{ $employee->gross_pay }}
        </td>
      </tr>

    @foreach($employee->cutoff_breakdown->_breakdown as $breakdown)
          @if($breakdown["label"] == 'Special Holiday')
              @if($holidays == 1)
                  <tr>
                    <td>
                       {{round($breakdown["amount"],2)}}
                    </td>
                  </tr>
                 @php
                    $holidays++;
                 @endphp
              @endif
          @endif
    @endforeach

    @if($holidays == 1)
      <tr>
        <td>-</td>
      </tr>
    @endif


      <tr>
        <td>
            {{$employee->cutoff_breakdown->basic_pay_total }}
        </td>
      </tr>

    @foreach($employee->cutoff_breakdown->_breakdown as $breakdown)
          @if($breakdown["label"] == 'Leave Pay')
              @if($leave == 1)
                  <tr>
                    <td>
                       {{round($breakdown["amount"],2)}}
                    </td>
                  </tr>
                 @php
                    $leave++;
                 @endphp
              @endif
          @endif
    @endforeach

    @if($leave == 1)
      <tr>
        <td>-</td>
      </tr>
    @endif


    @foreach($employee->cutoff_breakdown->_taxable_salary_breakdown as $breakdown)
      @if($breakdown["type"] == 'government_contributions')
        <tr>
          <td>
             {{$breakdown["amount"]}}
          </td>
        </tr>
      @endif
    @endforeach

    <tr>
      <td>
        {{$additions}}
      </td>
    </tr>

    <tr>
      <td>
        {{$deductions}}
      </td>
    </tr>

       <tr>
      <td>
        {{ $employee->net_pay }}
      </td>
    </tr>

  </table>
</div>

<div class="div1" style="width:50px;margin-bottom: 45px;">
      <table style="width:100%;display: inline-block;">
          <tr>
            <td style="padding-bottom: 122px;"><span>Employee Sign</span></td>
          </tr>
    </table>
  </div>



    </div>
      @endforeach


    </body>
</html>

