@extends('member.layout')
@section('content')
<div class="dashboard">
  <!-- add extra container element for Masonry -->
  <div class="grid row-no-padding clearfix">
    <div class="grid-item col-xs-8">
      <!-- add inner element for column content -->
      <div class="grid-item-content" style="position: relative;">
          <div class="text-center">
              <div class="grid-title active">VENDORS</div>
          </div>
          <div class="main-holder">
              <div class="per-row">
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Purchase Order</div>
                  </div>
                  <div class="horizontal-line" style="width: 15%;"></div>
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Receive Inventory</div>
                  </div>
                  <div class="horizontal-line" style="width: 15%;"></div>
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Enter Bills Against Inventory</div>
                  </div>
              </div>
              <div class="per-row">
                  <div class="vertical-line" style="height: 100px;"></div>
                  <div class="space-line" style="width: 7.5%;"></div>
                  <div class="holder">
                      <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                      <div class="name">Enter Bills</div>
                  </div>
              </div>
              
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Pay Bills</div>
              </div>
          </div>
      </div>
      <div class="grid-item-content">
          <div class="text-center">
              <div class="grid-title active">CUSTOMERS</div>
          </div>
          <div class="main-holder">
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Sales Orders</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Estimates</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Create Invoices</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Receive Payments</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Create Sales Receipts</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Statements</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Finance Charges</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Statement Charges</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Accept Credit Cards</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Refund & Credits</div>
              </div>
          </div>
      </div>
      <div class="grid-item-content">
          <div class="text-center">
              <div class="grid-title active">EMPLOYEES</div>
          </div>
          <div class="main-holder">
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Payroll Center</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Pay Employees</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Pay Liabilities</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Process Payroll Forms</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">HR Essentials and Insurance</div>
              </div>
          </div>
      </div>
    </div>
    <div class="grid-item col-xs-4">
      <!-- add inner element for column content -->
      <div class="grid-item-content">
          <div class="text-center">
              <div class="grid-title">COMPANY</div>
          </div>
          <div class="main-holder">
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Chart of Accounts</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Inventory Activities</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Items & Services</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Order Checks</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Calendar</div>
              </div>
          </div>
      </div>
      <div class="grid-item-content">
          <div class="text-center">
              <div class="grid-title">BANKING</div>
          </div>
          <div class="main-holder">
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Record Deposits</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Reconcile</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Write Checks</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Check Register</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Print Checks</div>
              </div>
              <div class="holder">
                  <div class="icon"><img src="/assets/member/img/sample-icon.png"></div>
                  <div class="name">Enter Credit Charges</div>
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