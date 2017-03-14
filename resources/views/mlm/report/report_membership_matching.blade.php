@extends('mlm.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        {!! $header !!}
        <div class="panel panel-default panel-block">
            <div class="list-group">
                @if(isset($report))
                <div class="list-group-item" id="responsive-bordered-table">
                    <div class="form-group">
                        <h4 class="section-title">
                        @if(isset($plan->marketing_plan_label)) {{$plan->marketing_plan_label}} @endif
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <th>ID</th>
                                    <th>DATE</th>
                                    <th>SPONSOR</th>
                                    <th>AMOUNT</th>
                                    <th>NOTIFICATION</th>
                                </thead>
                                @if(count($report) >= 1)    
                                @foreach($report as $key => $value)
                                <tbody>
                                    <tr>
                                        <td>{{$value->wallet_log_id}}</td>
                                        <td>{{$value->wallet_log_date_created}}</td>
                                        <td>{{$value->slot_no}}</td>
                                        <td>{{$value->wallet_log_amount}}</td>
                                        <td>{{$value->wallet_log_details}}</td>
                                    </tr>
                                </tbody>    
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5"><center>No Active Report.</center></td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <center>{!! $report->render() !!}</center>  
                </div>  
                @endif                       
            </div>
        </div>  
        <div class="panel panel-default panel-block hide">
            <div class="list-group">
                <div class="list-group-item" id="responsive-bordered-table">

                    <div class="form-group">
                        <h4 class="section-title">
                            MATCH HISTORY
                        </h4>
                        <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>
                                @if(isset($report_matching))
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @else
                                <tr><td colspan="40">No Matching History</td></tr>
                                @endif
                            </tbody>
                        </table>
                        @if(isset($report_matching))
                            <center>{!! $report_matching->render() !!}</center>
                        @else

                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>
</div>
@endsection