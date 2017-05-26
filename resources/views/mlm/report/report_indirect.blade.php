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
                                    <th></th>
                                    <th>ID</th>
                                    <th>DATE</th>
                                    <th>SPONSOR</th>
                                    <th>AMOUNT</th>
                                    <th>LEVEL</th>
                                    <th>NOTIFICATION</th>
                                </thead> 
                                @if(count($report) >= 1)
                                @foreach($report as $key => $value)
                                <tbody>
                                    <tr>
                                        <td>{!! mlm_profile($value) !!}</td>
                                        <td>{{$value->wallet_log_id}}</td>
                                        <td>{{$value->wallet_log_date_created}}</td>
                                        <td>{{$value->slot_no}}</td>
                                        <td>{{$value->wallet_log_amount}}</td>
                                        <td>{{$value->level}}</td>
                                        <td>{{$value->wallet_log_details}}</td>
                                    </tr>
                                </tbody>    
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6"><center>No Active Report.</center></td>
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
    </div>
</div>
@endsection