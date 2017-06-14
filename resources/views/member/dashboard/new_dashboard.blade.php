@extends('member.layout')
@section('content')
<div class="dashboard dashboard-home-content">
  <!-- add extra container element for Masonry- -->
  <div class="grid row-no-padding clearfix">
    <div class="grid-item col-md-8">
      <!-- add inner element for column content -->
      <div class="grid-item-content" style="position: relative;">
          <div class="text-center">
              <div class="grid-title active"><span>V</br>E</br>N</br>D</br>O</br>R</br>S</span></div>
          </div>
          <div class="main-holder">
              <div class="per-row">
                  <a href="javascript:">
                    <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Purchase Order</div>
                    </div>
                  </a>
                  <div class="horizontal-line right" style="width: 15%;"></div>
                  <a href="javascript">
                    <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Receive Inventory</div>
                    </div>
                  </a>
                  <div class="horizontal-line right" style="width: 15%;"></div>
                  <a href="javascript:">
                    <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Enter Bills Against Inventory</div>
                    </div>
                  </a>
              </div>
              <div class="per-row">
                  <a href="javascript:">
                    <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Enter Bills</div>
                    </div>
                  </a>
                  <div class="horizontal-line" style="width: 47.5%;"></div>
                  <div class="vertical-line intersecting"></div>
                  <div class="horizontal-line right" style="width: 20%;"></div>
                  <a href="javascript:">
                    <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Pay Bills</div>
                    </div>
                  </a>
              </div>
          </div>
      </div>
      <div class="grid-item-content">
          <div class="text-center">
              <div class="grid-title active"><span>C</br>U</br>S</br>T</br>O</br>M</br>E</br>R</br>S</span></div>
          </div>
          <div class="main-holder">
              <div class="per-row">
                <a href="javascript:">
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Sales Orders</div>
                      <div class="vertical-line up" style="height: 20px; vertical-align: middle; margin-top: 15px;"></div>
                  </div>
                </a>
                <div class="horizontal-line" style="width: 12.5%;"></div>
                <div class="vertical-line down" style="height: 100px; vertical-align: middle; margin-left: -7.5px; margin-right: -7.5px; margin-top: 25px;"></div>
                <div class="space-line" style="width: 35%;"></div>
                <a href="javascript:">
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Create Sales Receipts</div>
                  </div>
                </a>
                <div class="space-line" style="width: 5%;"></div>
                <a href="javascript:">
                  <div class="holder">
                    <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                    <div class="name">Refund & Credits</div>
                  </div>
                </a>
              </div>
              <div class="per-row">
                <a href="javascript:">
                  <div class="holder">
                    <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                    <div class="name">Estimates</div>
                  </div>
                </a>
                <div class="horizontal-line" style="width: 7.5%;"></div>
                <a href="javascript:">
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Create Invoices</div>
                  </div>
                </a>
                <div class="horizontal-line right" style="width: 30%;"></div>
                <a href="javascript:">
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Receive Payments</div>
                  </div>
                </a>
              </div>
          </div>
      </div>
      <div class="grid-item-content">
          <div class="text-center">
              <div class="grid-title active"><span>E</br>M</br>P</br>L</br>O</br>Y</br>E</br>E</br>S</span></div>
          </div>
          <div class="main-holder">
              <div class="per-row">
                <a href="javascript:">
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Payroll Center</div>
                  </div>
                </a>
                <div class="space-line" style="width: 10%;"></div>
                <a href="javascript:">
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Pay Employees</div>
                  </div>
                </a>
                <div class="horizontal-line" style="width: 7.5%;"></div>
                <a href="javascript:">
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Pay Liabilities</div>
                  </div>
                </a>
                <div class="horizontal-line right" style="width: 7.5%;"></div>
                <a href="javascript:">
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Process Payroll Forms</div>
                  </div>
                </a>
                <div class="space-line" style="width: 7.5%;"></div>
                <a href="javascript:">
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">HR Essentials and Insurance</div>
                  </div>
                </a>
              </div>
          </div>
      </div>
    </div>
    <div class="grid-item col-md-4">
      <!-- add inner element for column content -->
      <div class="grid-item-content mini-side">
          <div class="text-center">
              <div class="grid-title"><span>M</br>E</br>M</br>B</br>E</br>R</br>S</br>H</br>I</br>P</span></div>
          </div>
          <div class="main-holder">
              <div class="centered">
                  <div class="per-row">
                    <a href="javascript:">
                      <div class="holder">
                          <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                          <div class="name">Chart of Accounts</div>
                      </div>
                    </a>
                    <div class="space-line" style="width: 30px;"></div>
                    <a href="javascript:">
                      <div class="holder">
                          <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                          <div class="name">Inventory Activities</div>
                      </div>
                    </a>
                  </div>
                  <div class="per-row">
                    <a href="javascript:">
                      <div class="holder">
                          <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                          <div class="name">Items & Services</div>
                      </div>
                    </a>
                    <div class="space-line" style="width: 30px;"></div>
                    <a href="javascript:">
                      <div class="holder">
                          <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                          <div class="name">Order Checks</div>
                      </div>
                    </a>
                  </div>
                  <div class="per-row">
                    <a href="javascript:">
                      <div class="holder">
                          <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                          <div class="name">Calendar</div>
                      </div>
                    </a>
                  </div>
              </div>
          </div>
      </div>
      <div class="grid-item-content mini-side">
          <div class="text-center">
              <div class="grid-title"><span>B</br>A</br>N</br>K</br>I</br>N</br>G</span></div>
          </div>
          <div class="main-holder">
            <div class="centered">
                <div class="per-row">
                  <a href="javascript:">
                    <div class="holder">
                        <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                        <div class="name">Record Deposits</div>
                    </div>
                  </a>
                  <div class="space-line" style="width: 30px;"></div>
                  <a href="javascript:">
                    <div class="holder">
                        <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                        <div class="name">Reconcile</div>
                    </div>
                  </a>
                </div>
                <div class="per-row">
                  <a href="javascript:">
                    <div class="holder">
                        <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                        <div class="name">Write Checks</div>
                    </div>
                  </a>
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<div id="page-wrapper dashboard-insights-content">
   <div class="col-md-12">
   <span class="fa fa-angle-left fa-4x dashboard-home cursor-pointer"></span>&nbsp;<span class="fa fa-angle-right fa-4x dashboard-insights cursor-pointer"></span>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="col-md-4">
            <div class="panel panel-default" id="panel-height">
               <div class="panel-heading">
                  <div class="pull-left" id="font1">Expenses</div>
                  <div class="pull-right">
                     
                     <div class="dropdown">
                        <div class="dropdown-toggle" type="button" data-toggle="dropdown">Last Month
                           <span class="caret"></span>
                        </div>
                        <ul class="dropdown-menu">
                           <li><a href="#">Last 30 days</a></li>
                           <li><a href="#">This Month</a></li>
                           <li><a href="#">This Quarter</a></li>
                           <li><a href="#">This Year</a></li>
                           <li><a href="#">Last Month</a></li>
                           <li><a href="#">Last Quarter</a></li>
                           <li><a href="#">Last Year</a></li>
                        </ul>
                     </div>
                  </div>
                  <br>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-12">
                        <!--PIE GRAPH-->
                        <div class="pg-title">
                           Last Month
                        </div>
                        <div id="pie-chart-content">
                           <div class="table">
                              <div class="cell">
                                 <canvas id="pie-chart" class="pie"></canvas>
                              </div>
                              <div class="cell chart-legend"></div>
                           </div>
                        </div>
                        <!--END OF PG-->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="panel panel-default" id="panel-height">
               <div class="panel-heading">
                  <div class="pull-left" id="font1">Income</div>
                  <div class="pull-right">
                     Last 365 days
                  </div>
                  <br>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-12">
                        <!--Bar - Stacked-->
                        <div id="bar-chart-content">
                           <div class="table">
                              <div class="cell">
                                 <canvas id="bar-chart" class="bar"></canvas>
                              </div>
                              <div class="cell chart-legend"></div>
                           </div>
                        </div>
                        <!--END-->
                     </div>
                     <!-- <div class="col-md-5" id="right-pane-inc">
                        <div>
                           <text class="open-invoices"><b>{{count($open_invoice)}}</b></text></br>
                           <text>OPEN INVOICES</text></br></br>
                        </div>
                        <div>
                           <text class="overdue-invoices"><b>{{count($overdue_invoice)}}</b></text></br>
                           <text>OVERDUE</text></br></br>
                        </div>
                        <div>
                           <text class="paid-invoices"><b>{{count($paid_invoice)}}</b></text></br>
                           <text>PAID LAST 30 DAYS</text></br></br>
                        </div>
                     </div> -->
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="panel panel-default" id="panel-height">
               <div class="panel-heading">
                  <div class="pull-left" id="font1">Sales</div>
                  <div class="pull-right">
                     <div class="dropdown">
                        <div class="dropdown-toggle" type="button" data-toggle="dropdown">Last Month
                           <span class="caret"></span>
                        </div>
                        <ul class="dropdown-menu">
                           <li><a href="#">Last Year</a></li>
                           <li><a href="#">This Month</a></li>
                           <li><a href="#">This Year</a></li>
                        </ul>
                     </div>
                  </div>
                  <br>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-12">
                        <canvas id="line-graph" ></canvas>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="col-md-4">
            <div class="panel panel-default" id="panel-height">
               <div class="panel-heading">
                  <div class="pull-left" id="font1">Back Accounts</div>
                  <div class="pull-right">
                     <a href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                  </div>
                  <br>
               </div>
               
               <div class="panel-body">
                  <div class="form-group">
                     @foreach($_bank as $key=>$bank)
                        {!! $key==0 ? '' : '<hr>' !!}
                        <text class="bank-title">{{$bank->account_name}}</text><br>
                        <div class="panel"></div>
                     @endforeach
                  </div>
                  <div class="row" id="bank-bot-pane">
                     <div class="col-md-7">
                        <div class="pull-left">
                           <a href="#" id="textlign"> Connect account </a>
                        </div>
                     </div>
                     <div class="col-md-5">
                        <div class="pull-right">
                           <a href="#" id="textlign"> Go to Regiters </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="panel panel-default" id="panel-height">
               <div class="panel-heading">
                  <div class="pull-left" id="font1">Other</div>
                  <br>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jointjs/1.1.0/joint.min.css">
<link rel="stylesheet" type="text/css" href="/assets/member/css/new_dashboard.css">
<link rel="stylesheet" type="text/css" href="/assets/member/css/dashboard.css">
<style type="text/css">
.chart-legend ul {
list-style: none;
margin: 0;
padding: 0;
}
.chart-legend span {
display: inline-block;
width: 14px;
height: 14px;
border-radius: 100%;
margin-right: 16px;
margin-bottom: -2px;
}
.chart-legend li {
margin-bottom: 10px;
display: inline-block;
margin-left: 20px;
}
canvas {
width: 100% !important;
height: auto !important;
}
.table {
display: table;
width: 100%;
table-layout: fixed;
}
.cell {
display: table-cell;
vertical-align: middle;
}
</style>
@endsection
@section('script')
<script type="text/javascript">
var open_invoice    = {{count($open_invoice)}};
var overdue_invoice = {{count($overdue_invoice)}};
var paid_invoice    = {{count($paid_invoice)}};
var expense_value    = {!!$expense_value !!};
var expense_name     = {!!$expense_name !!};
var expense_color    = {!!$expense_color !!};
var income_date     = {!! $income_date !!}
var income_value    = {!! $income_value !!}
</script>
<script type="text/javascript" src='/assets/member/js/dashboard_chart.js'></script>
<script type="text/javascript" src="/assets/member/js/new_dashboard.js"></script>
@endsection