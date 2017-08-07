@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
            <span class="page-title">Developer Menu for MLM</span>
            <small style="font-size: 14px; color: gray;">
                You can use this page to perform actions that can't be performaned even by <b>SUPER ADMINS</b>
            </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
 	<div class="panel-body form-horizontal">
         <div class="form-group">
            <div class="col-md-2">            
                <label>NO. OF SLOTS</label>
                <input type="text" class="form-control" readonly value="{{ $slot_count }}">
            </div>
            <div class="col-md-3">            
                <label>CURRENT WALLET OF SLOTS</label>
                <input type="text" class="form-control" readonly value="{{ $total_slot_wallet }}">
            </div>
            <div class="col-md-3">            
                <label>EARNINGS OF SLOTS</label>
                <input type="text" class="form-control" readonly value="{{ $total_slot_earnings }}">
            </div>

            <div class="col-md-2">            
                <label>TOTAL PAYOUT</label>
                <input type="text" class="form-control" readonly value="{{ $total_payout }}">
            </div>
            <div class="col-md-2 text-right pull-right">  
            	<label style="color: #fff;">TOTAL WALLET</label>          
               	<button onclick="action_load_link_to_modal('/member/mlm/developer/create_slot')" class="btn btn-primary"><i class="fa fa-plus"></i> CREATE TEST SLOT</button>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group tab-content panel-body employee-container">
            <div id="all" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">SLOT ID</th>
                                <th class="text-center">SLOT KEY</th>
                                <th class="text-center">SLOT OWNER</th>
                                <th class="text-center">DATE CREATED</th>
                                <th class="text-center">TIME CREATED</th>
                                <th class="text-right">CURRENT WALLET</th>
                            </tr>
                        </thead>
                        <tbody class="table-warehouse">
                            @foreach($_slot as $key => $slot)
                            <tr>
                                <td class="text-center">{{ $slot->slot_id }}</td>
                                <td class="text-center">{{ $slot->slot_no }}</td>
                                <td class="text-center">{{ strtoupper($slot->last_name) }}, {{ strtoupper($slot->first_name) }} {{ strtoupper($slot->middle_name) }}</td>
                                <td class="text-center">{{ date("F d, Y", strtotime($slot->slot_created_date)) }}</td>
                                <td class="text-center">{{ date("h:i A", strtotime($slot->slot_created_date)) }}</td>
                                <td class="text-right">{!! $slot->current_wallet_format !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pull-right">{!! $_slot_page->render() !!}</div>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection