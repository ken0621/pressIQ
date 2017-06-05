<div class="box box-primary">
            <div class="box-body">
                <div class="list-group">
                    @if(isset($report))
                        <div class="form-group">
                            <h4 class="section-title">
                            @if(isset($plan->marketing_plan_label)) {{$plan->marketing_plan_label}} @endif
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed">
                                    <thead>
                                        <th class="info" style="text-align: center;">ID</th>
                                        <th class="info" style="text-align: center;">SPONSOR</th>
                                        <th class="info" style="text-align: center;">DATE</th>
                                        <th class="info" style="text-align: center;">AMOUNT</th>
                                        <th class="info" style="text-align: center;">NOTIFICATION</th>
                                    </thead>
                                    @if(count($report) >= 1)    
                                    @foreach($report as $key => $value)
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center;">{{$value->wallet_log_id}}</td>
                                            <td style="text-align: center;">{{name_format_from_customer_info($value)}}</td>
                                            <td style="text-align: center;">{{$value->wallet_log_date_created}}</td>
                                            <td style="text-align: center;">{{$value->wallet_log_amount}}</td>
                                            <td style="text-align: center;">{{$value->wallet_log_details}}</td>
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
                    @else
                        <center>No Active Report.</center>  
                    @endif      
                    <center>{!! $report->render() !!}</center>                   
                </div>  
            </div>
        </div>         