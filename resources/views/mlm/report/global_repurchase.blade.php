<div class="box box-primary">
            <div class="box-body">
                <div class="list-group">
                    @if(isset($points_log))
                        <div class="form-group">
                            <h4 class="section-title">
                            POINTS LOG
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed">
                                    <thead>
                                        <th class="info" style="text-align: center;">ID</th>
                                        <th class="info" style="text-align: center;">DATE</th>
                                        <th class="info" style="text-align: center;">LEVEL</th>
                                        <th class="info" style="text-align: center;">SPONSOR</th>
                                        <th class="info" style="text-align: center;">POINTS</th>
                                        <th class="info" style="text-align: center;">TYPE</th>
                                    </thead>
                                    @if(count($points_log) >= 1)    
                                    @foreach($points_log as $key => $value)
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center;">{{$value->points_log_id}}</td>
                                            <td style="text-align: center;">{{$value->points_log_date_claimed}}</td>
                                            <td style="text-align: center;">
                                            @if($value->points_log_points >= 1)
                                            {{$value->points_log_level}}
                                            @else
                                            {{$value->points_log_leve_start}} - {{$value->points_log_leve_end}}
                                            @endif
                                            </td>
                                            <td style="text-align: center;">{{name_format_from_customer_info($value)}} - {{$value->slot_no}}</td>
                                            <td style="text-align: center;">{{$value->points_log_points}}</td>
                                            <td style="text-align: center;">{{$value->points_log_type}}</td>
                                        </tr>
                                    </tbody>    
                                    @endforeach


                                    @else
                                    <tr>
                                        <td colspan="5"><center>No Points.</center></td>
                                    </tr>
                                    @endif
                                </table>
                                <center>{!! $points_log->render() !!}</center>
                            </div>
                        </div>
                       @else
                        <center>Points Not Found.</center>  
                    @endif                       
                </div> 
            </div>
        </div>