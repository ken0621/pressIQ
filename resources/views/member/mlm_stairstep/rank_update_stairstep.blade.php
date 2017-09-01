@extends('member.layout')
@section('content')

<form method="post">
  <div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
      <div>
        <i class="fa fa-angle-double-up" aria-hidden="true"></i>
        <h1>
          <span class="page-title">Rank Update <i class="fa fa-angle-double-right"></i> Update</span>
          <small>
            Update Ranks of SLots of Customers
          </small>
        </h1>
        <button type="button" id="button1" class="btn btn-sm"><span><i class="fa fa-refresh" aria-hidden="true"></i></span>  Update Ranking</button>
        <button type="button" id="button2" class="btn btn-sm" data-toggle="modal" data-target="#classModal"><span><i class="fa fa-refresh" aria-hidden="true"></i></span>  Rank Update History</button>
      </div>
    </div>
  </div>
</form>
<div class="panel panel-default panel-block panel-title-block" id="top">
  <div class="panel-heading">
  <br>
  <br>         
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><center>Customer Name</center></th>
        <th><center>Slot No.</center></th>
        <th><center>Current Rank</center></th>
        <th><center>Personal RANK-PV</center></th>
        <th><center>Group RANK-PV</center></th>
        <th><center>Next Rank Qualified</center></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><center>John</center></td>
        <td><center><a href="" class='underline'><span>Doe</span></a></center></td>
        <td><center>john@example.com</center></td>
        <td><center>john@example.com</center></td>
        <td><center>john@example.com</center></td>
        <td><center><input type="checkbox" name="name1" />&nbsp;</center></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
</div>

<div id="classModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> 
        </button>
      
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-condensed">
          <thead>
            <tr>
              <th><center>Date Updated</center></th>
              <th><center>No of Slots Updated</center></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><center>John</center></td>
              <td><center><a data-toggle="modal" href="#modal1" class='underline'><span>25 SLOTS</span></a></center></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

<div id="modal1" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          
        </button>
        <h4 class="modal-title" id="classModalLabel">
         Rank Update for October 15,2016
       </h4>
     </div>
     <div class="modal-body">
      <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th><center>Customer Name</center></th>
            <th><center>Slot No.</center></th>
            <th><center>Current Rank</center></th>
            <th><center>Personal STAIR-PV</center></th>
            <th><center>Group STAIR-PV</center></th>
            <th><center>New Rank</center></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><center>John</center></td>
            <td><center><a href="#" class='underline'><span>12</span></a></center></td>
            <td><center>john@example.com</center></td>
            <td><center>john@example.com</center></td>
            <td><center>john@example.com</center></td>
            <td><center>john@example.com</center></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" data-dismiss="modal">
        Close
      </button>
    </div>
  </div>
</div>
</div>

@endsection

<style> 
  div button {
    float: right;
    margin-right:10px;

  }

  #classModal {}

  .modal-body {
    overflow-x: auto;
  }


  a.underline {
    text-decoration: none;
  }
  a.underline span {
    display: inline-block;
    border-bottom: 1px solid blue;
    font-size: 15px;
    line-height: 12px;
  }

  th {
    white-space: nowrap;
  }

  td{
    white-space: nowrap;

  }
  
  .page-title{
    color: skyblue !important;   
  }
  #button1{
    border-color:#36a6fd;
    background: white !important; 
    color: skyblue !important; 
  }
  #button2{
    border-color:#36a6fd;
    background: white !important; 
    color: skyblue !important; 
  }

</style>
<style> 

  .stylish-input-group .input-group-addon{
    background: white !important; 

  }
  .stylish-input-group .form-control{
    border-color:#ccc;
  }
  .stylish-input-group button{
    border:0;
    background:transparent;
  }

  .datepicker{
    border-color:#ccc;
  }
</style>

