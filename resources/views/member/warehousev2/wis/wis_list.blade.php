@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-archive"></i>
            <h1>
                <span class="page-title">Warehouse Issuance Slip</span>
            </h1>
            <div class="text-right">
                <a class="btn btn-primary panel-buttons" href="/member/item/warehouse/wis/create">Create</a>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-6">
                <ul class="nav nav-tabs">
                  <li id="all-list" class="active"><a data-toggle="tab" href="#all"><i class="fa fa-star" aria-hidden="true"></i>&nbsp;Pending</a></li>
                  <li id="archived-list"><a data-toggle="tab" href="#archived"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Confirmed WIS</a></li>
                  <li id="archived-list"><a data-toggle="tab" href="#archived"><i class="fa fa-hand-grab-o" aria-hidden="true"></i>&nbsp;Received</a></li>
                </ul>
            </div>
        </div>

        <div class="form-group tab-content panel-body warehouse-container">
            <div id="all" class="tab-pane fade in active">
                
            </div>
        </div>        
    </div>
</div>
@endsection