
@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Notification';
$data['sub'] = 'All income notification are shown here.';
$data['icon'] = 'fa fa-star-half-o';
?>
@include('mlm.header.index', $data)
<div class="row">
    <div class="col-md-12">
        <form method="POST">
        <div class="panel panel-default panel-block">
            <div class="list-group">
                <div class="list-group-item" id="responsive-bordered-table">
                    <div class="form-group">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condensed">
                            @if(isset($report))
                                @if(count($report) != 0)
                                        <th>ID</th>
                                        <th><center>Details</center></th>
                                        <th></th>
                                    @foreach($report as $key => $value)
                                        <tr>
                                            <td>{{$value->wallet_log_id}}</td>
                                            <td><center><p>{{$value->wallet_log_details}}</p></center></td>
                                            <td>@if($value->wallet_log_notified == 1) Seen @endif</td>
                                        </tr>
                                    @endforeach 
                                @else
                                    <tr><td><center>No Notification available.</center></td></tr>
                                @endif
                            @else
                                <tr><td><center>No Notification available.</center></td></tr>
                            @endif

                            </table>
                            <center>{!!$report->render()!!}</center>
                        </div>
                    </div>
                </div>                 
            </div>
        </div> 
        
        </form> 
        <div>

    </div>
    </div>
</div>
@endsection