@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Stock Issuance Report and Load Out Form</span>
                <small>
                    List of SIR and LOF
                </small>
            </h1>
            <a class="panel-buttons btn btn-custom-primary pull-right" href="/member/pis/sir/create" >Create Load Out Form</a>
        </div>
    </div>
</div>
<!-- TEMPORARY -->
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div class="form-group">
            <div class="col-md-4">
                <a link="/member/pis/sir/confirm_sync/import" size="md" class="popup btn btn-primary">Sync Import Data</a>
            </div>
            <div class="col-md-4">
                <a link="/member/pis/sir/confirm_sync/export" size="md" class="popup btn btn-primary">Sync Export Data</a>
            </div>
        </div>
    </div>
</div>
<!-- END TEMPORARY -->

<!-- NO PRODUCT YET -->
<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <ul class="nav nav-tabs">
        <li class="active cursor-pointer all-sir"><a class="cursor-pointer" onclick="select('all')" data-toggle="tab" href="#all"><i class="fa fa-star"></i> All</a></li>
        <li class="cursor-pointer sir-class"><a class="cursor-pointer"  onclick="select(0,0,'',0)" data-toggle="tab" href="#new"><i class="fa fa-reorder"></i> Load Out Form</a></li>
        <li class="cursor-pointer sir-class"><a class="cursor-pointer"  onclick="select(1,0,'',0)" data-toggle="tab" href="#open"><i class="fa fa-folder-open"></i> Open SIR</a></li>
        <li class="cursor-pointer sir-class"><a class="cursor-pointer"  onclick="select(1,0,'',1)" data-toggle="tab" href="#sync"><i class="fa fa-refresh"></i> Currently Synced</a></li>
        <li class="cursor-pointer sir-class"><a class="cursor-pointer"  onclick="select(2,0,'',1)" data-toggle="tab" href="#closed"><i class="fa fa-window-close"></i> Closed SIR</a></li>
        <li class="cursor-pointer sir-class"><a class="cursor-pointer" onclick="select('',1,'',0)" data-toggle="tab" href="#archived"><i class="fa fa-trash"></i> Archived SIR</a></li>
    </ul>
    <div class="search-filter-box">
        <div class="col-md-4" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search_name" id="srch_sir_id" placeholder="Search by SIR number" aria-describedby="basic-addon1">
            </div>
        </div>  
    </div>
    <div class="form-group tab-content panel-body sir_container">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>SIR No</th>
                            <th>SIR Created</th>
                            <th>Truck Plate No</th>
                            <th>Sales Agent</th>
                            <th>Total Item</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @if($_sir)
                           @foreach($_sir as $sir)
                                <tr>
                                    <td align="center">{{$sir->sir_id}}</td>
                                    <td>{{date('F d, Y', strtotime($sir->sir_created))}}</td>
                                    <td>{{$sir->plate_number}}</td>
                                    <td>{{$sir->first_name}} {{$sir->middle_name}} {{$sir->last_name}}</td>
                                    <td>{{$sir->total_item}}</td>
                                    <td>{{currency("PHP",$sir->total_amount)}}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                          <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <span class="caret"></span>
                                          </button>
                                          @if($sir->sir_archived == 1)
                                            <ul class="dropdown-menu dropdown-menu-custom">
                                                <li><a size="md" link="/member/pis/sir/{{$sir->sir_id}}/restore" class="popup">Restore SIR</a></li>
                                            </ul>
                                          @else
                                              @if($sir->sir_status == 0)
                                              <ul class="dropdown-menu dropdown-menu-custom">
                                                <li><a size="lg" link="/member/pis/sir/view/{{$sir->sir_id}}/lof" class="popup">View Load Out Form</a></li>
                                                <li><a href="/member/pis/sir/edit/{{$sir->sir_id}}">Edit Load Out Form</a></li>
                                                <li><a size="md" link="/member/pis/sir/{{$sir->sir_id}}/archived" class="popup">Archive L.O.F</a></li>
                                                <li><a size="md" link="/member/pis/sir/open/{{$sir->sir_id}}/open" class="popup">OPEN THIS AS SIR</a></li>
                                              </ul>
                                              @elseif($sir->ilr_status == 2)                                        
                                              <ul class="dropdown-menu dropdown-menu-custom">
                                                <li><a size="lg" link="/member/pis/ilr/view/{{$sir->sir_id}}" class="popup">View ILR</a></li>
                                              </ul>
                                              @elseif($sir->is_sync == 1 )
                                              <ul class="dropdown-menu dropdown-menu-custom">                                                  
                                                <li><a size="lg" link="/tablet/sir_inventory/{{$sir->sir_id}}" class="popup">View Inventory</a></li>
                                                <li><a href="/member/pis/manual_invoice/add/{{$sir->sir_id}}">Create Manual Invoices</a></li>
                                              </ul>
                                              @elseif($sir->sir_status == 1)                                          
                                              <ul class="dropdown-menu dropdown-menu-custom">
                                                <li><a size="lg" link="/member/pis/sir/view/{{$sir->sir_id}}/sir" class="popup">View SIR</a></li>
                                              </ul>
                                              @elseif($sir->ilr_status == 1)                                          
                                              <ul class="dropdown-menu dropdown-menu-custom">
                                                <li><a size="lg" link="/member/pis/sir/view/{{$sir->sir_id}}/sir" class="popup">View SIR</a></li>
                                                <li><a href="/member/pis/ilr/{{$sir->sir_id}}">Processed ILR</a></li>
                                              </ul>
                                              @endif
                                          @endif
                                        </div>
                                    </td>
                                </tr>
                           @endforeach
                       @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    
</div>
@endsection
@section("script")
<script type="text/javascript">
    var status_s = 'all';
    var archived_s = 0;
    var is_sync_s = 0;
    $("#srch_sir_id").keyup(function()
    {
        select(status_s, archived_s, $(this).val(),is_sync_s);
    });
    function select(status,archived,sir_id = '',is_sync)
    {        
        $(".modal-loader").removeClass("hidden");
        status_s = status;
        archived_s = archived;
        is_sync_s = is_sync;
        $(".sir_container").load("/member/pis/sir?status="+status +"&archived="+archived + "&sir_id="+sir_id + "&is_sync="+is_sync +" .sir_container", function()
            {
                $(".modal-loader").addClass("hidden");
            });
        
    }
</script>
<script type="text/javascript" src="/assets/member/js/sir.js"></script>
@endsection