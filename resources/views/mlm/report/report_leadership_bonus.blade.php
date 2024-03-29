@extends('mlm.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        {!! $header !!}
        <form method="POST">
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
                                    <th>AMOUNT</th>
                                    <th>NOTIFICATION</th>
                                </thead>
                                @if(count($report) >= 1)    
                                @foreach($report as $key => $value)
                                <tbody>
                                    <tr>
                                        <td>{{$value->wallet_log_id}}</td>
                                        <td>{{$value->wallet_log_date_created}}</td>
                                        <td>{{$value->wallet_log_amount}}</td>
                                        <td>{{$value->wallet_log_details}}</td>
                                    </tr>
                                </tbody>    
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4"><center>No Active Report.</center></td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                @else
                    <center>No Active Report.</center>  
                @endif      
                <center>{!! $report->render() !!}</center>                   
            </div>
        </div>  

        <div class="panel panel-default panel-block ">
            <div class="list-group">
                @if(isset($points_log))
                <div class="list-group-item" id="responsive-bordered-table">
                    <div class="form-group">
                        <h4 class="section-title">
                        POINTS LOG
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <th>ID</th>
                                    <th>DATE</th>
                                    <th>LEVEL</th>
                                    <th>SPONSOR</th>
                                    <th>POINTS</th>
                                    <th>TYPE</th>
                                </thead>
                                @if(count($points_log) >= 1)    
                                @foreach($points_log as $key => $value)
                                <tbody>
                                    <tr>
                                        <td>{{$value->points_log_id}}</td>
                                        <td>{{$value->points_log_date_claimed}}</td>
                                        <td>
                                        @if($value->points_log_points >= 1)
                                        {{$value->points_log_level}}
                                        @else
                                        {{$value->points_log_leve_start}} - {{$value->points_log_leve_end}}
                                        @endif
                                        </td>
                                        <td>{{$value->points_log_Sponsor}}</td>
                                        <td>{{$value->points_log_points}}</td>
                                        <td>{{$value->points_log_type}}</td>
                                    </tr>
                                </tbody>    
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5"><center>No Points.</center></td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                @else
                    <center>Points Not Found.</center>  
                @endif                       
            </div>
        </div> 
        </form>           
        <div>

    </div>
    </div>
</div>
@endsection