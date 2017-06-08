@extends('member.layout')
@section('content')
<div class="dashboard">
  <!-- add extra container element for Masonry -->
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
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jointjs/1.1.0/joint.min.css">
<link rel="stylesheet" type="text/css" href="/assets/member/css/new_dashboard.css">
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/new_dashboard.js"></script>
@endsection