@extends('member.layout')
@section('content')
<div id="page-wrapper">
   
   
   
   <div class="col-md-12">
   </div>
   <div class="row">
      <div class="col-md-4">
         <div class="panel panel-default" id="panel-height">
            <div class="panel-heading">
               <div class="pull-left" id="font1">Expenses</div>
               <div class="pull-right">
                  
                  <div class="dropdown">
                     <div class="dropdown-toggle" type="button" data-toggle="dropdown">Last Month
                        <span class="caret"></span></div>
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
                     <div class="col-md-7">
                        <!--PIE GRAPH-->
                        <div class="pg-title">
                           Last Month
                        </div>
                        <div class="pie-chart">
                           <canvas id="myChart"></canvas>
                        </div>
                        <!--END OF PG-->
                     </div>
                     <div class="col-md-5" id="right-pane-exp">
                        94% <br>
                        Purchases S <br>
                        6% <br>
                        Cost of Goods Sold
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
                     Last 465 days
                  </div>
                  <br>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-3">
                        <!--Bar - Stacked-->
                        <div style="width: 75%">
                           <canvas id="canvas"></canvas>
                        </div>
                        <!--END-->
                     </div>
                     <div class="col-md-9" id="right-pane-inc">
                        <div>
                           <text class="open-invoices">{{count($open_invoice)}}</text></br>
                           <text>OPEN INVOICES</text></br></br>
                        </div>
                        <div>
                           <text class="overdue-invoices">{{count($overdue_invoice)}}</text></br>
                           <text>OVERDUE</text></br></br>
                        </div>
                        <div>
                           <text class="paid-invoices">{{count($paid_invoice)}}</text></br>
                           <text>PAID LAST 30 DAYS</text></br></br>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
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
                     <text class="bank-title">BDO Account</text><br>
                     <input type="text" class="form-control" name="bdoacc">
                     <text class="bank-title">BPI Bank</text> <br>
                     <input type="text" class="form-control" name="bpiacc">
                     <text class="bank-title">Credit Card</text> <br>
                     <input type="text" class="form-control" name="creditc">
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
      </div>
      <div class="row">
         <div class="col-md-4">
            <div class="panel panel-default" id="panel-height">
               <div class="panel-heading">
                  Sales
                  <div class="pull-right">
                     <div class="dropdown">
                        <div class="dropdown-toggle" type="button" data-toggle="dropdown">Last Month
                           <span class="caret"></span></div>
                           <ul class="dropdown-menu">
                              <li><a href="#">Last Year</a></li>
                              <li><a href="#">This Month</a></li>
                              <li><a href="#">This Year</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="panel-body">
                     <canvas id="ChartGraph" ></canvas>
                  </div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="panel panel-default" id="panel-height">
                  <div class="panel-heading">
                     Tips
                  </div>
               </div>
            </div>
         </div>

      </div>
      @endsection
      @section('script')
      <script type="text/javascript" src='/assets/member/js/dashboard_chart.js'></script>
      @endsection