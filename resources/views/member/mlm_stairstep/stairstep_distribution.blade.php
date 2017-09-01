@extends('member.layout')
@section('content')

<form method="post">
  <div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
      <div>
        <i class="fa fa-dropbox" aria-hidden="true"></i>
        <h1>
          <span class="page-title">Stair Step Distribution <i class="fa fa-angle-double-right"></i> Distribution</span>
          <small>
            Distribute Stair Step
          </small>
        </h1>
        <button type="button" id="button1" class="btn btn-sm"><span><i class="fa fa-exchange" aria-hidden="true"></i></span>  Distribute Stair Step</button>
        <button type="button" id="button2" class="btn btn-sm" data-toggle="modal" data-target="#classModal"><span><i class="fa fa-history" aria-hidden="true"></i></span>  Distribute History</button>
      </div>
    </div>
  </div>
</form>

<div class="panel panel-default panel-block panel-title-block" id="top">
  <div class="panel-heading">
  <div class="row">
    <div class="col-md-3">
      <div class="input-group stylish-input-group pull-right">
        <input type="text" class="form-control pull-right  datepicker">
        <span class="input-group-addon">
          <button type="submit">
            <i class="fa fa-calendar fa-lg datepicker" aria-hidden="true"></i>
          </button>  
        </span>
      </div>
    </div>
    <div class="col-md-3">
      <div class="input-group stylish-input-group pull-right">
        <input type="text" class="form-control pull-right  datepicker">
        <span class="input-group-addon">
          <button type="submit">
            <i class="fa fa-calendar fa-lg datepicker" aria-hidden="true"></i>
          </button>  
        </span>
      </div>
    </div>
    <div class="col-md-3 pull-right">
      <div class="input-group stylish-input-group pull-right">
        <input type="text" class="form-control pull-right"  placeholder="Search" >
        <span class="input-group-addon">
          <button type="submit">
            <i class="fa fa-search" aria-hidden="true"></i>
          </button>  
        </span>
      </div>
    </div>
    </div>
  <br>        
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th><center>Customer Name</center></th>
        <th><center>Slot No.</center></th>
        <th><center>Current Rank</center></th>
        <th><center>Current Personal-PV</center></th>
        <th><center>Stair Step Points</center></th>
        <th><center>Comission</center></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><center>John</center></td>
        <td><center>Doe</center></td>
        <td><center>john@example.com</center></td>
        <td><center>john@example.com</center></td>
        <td><center>john@example.com</center></td>
        <td><center>john@example.com</center></td>
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
        <h4 class="modal-title" id="classModalLabel">
          Distribute History
        </h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-condensed">
          <thead>
            <tr>
              <th><center>Date Start</center></th>
              <th><center>Date End</center></th>
              <th><center>Date Processed</center></th>
              <th><center>Slots Processed</center></th>
              <th><center></center></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><center>John</center></td>
              <td><center>Doe</center></td>
              <td><center>john@example.com</center></td>
              <td><center>john@example.com</center></td>
              <td><center><a data-toggle="modal" href="#modal1" class='underline'><span>View Summary</span></a></center></td>
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
         October 29,2016 to November 15,2017
       </h4>
     </div>
     <div class="modal-body">
     <div class="container">
      <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th><center>Customer Name</center></th>
            <th><center>Slot No.</center></th>
            <th><center>Current Rank</center></th>
            <th><center>Current PERSONAL-PV</center></th>
            <th><center>Required PERSONAL-PV</center></th>
            <th><center>Comission</center></th>
            <th><center>Status</center></th>
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
            <td><center>View Summary</center></td>
          </tr>
        </tbody>
      </table>
      </div>
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

