<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-block">
            <div class="list-group">
                @if(isset($points_log))
                <div class="list-group-item" id="responsive-bordered-table">
                    <div class="form-group">
                        <h4 class="section-title">
                        @if(isset($plan->marketing_plan_label)) {{$plan->marketing_plan_label}} @endif
                        </h4>
                        <div class="table-responsive">
                            <center>Points Log</center>
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <th>ID</th>
                                    <th>DATE</th>
                                    <th>SPONSOR</th>
                                    <th>POINTS</th>
                                    <th>TYPE</th>
                                    <th>STATUS</th>
                                </thead>
                                @if(count($points_log) >= 1)    
                                @foreach($points_log as $key => $value)
                                <tbody>
                                    <tr>
                                        <td>{{$value->points_log_id}}</td>
                                        <td>{{$value->points_log_date_claimed}}</td>
                                        <td>{{$value->slot_no}}</td>
                                        <td>{{$value->points_log_points}}</td>
                                        <td>{{$value->points_log_type}}</td>
                                        <td>
                                          <?php 
                                          $status[0] = 'Pending';
                                          $status[1] = 'Used';
                                          ?>
                                          {{$status[$value->points_log_converted]}}
                                        </td>
                                    </tr>
                                </tbody>    
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6"><center>No Points.</center></td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                @else
                    <center>Points Not Found.</center>  
                @endif  
                <center>{!! $points_log->render() !!}</center>                     
            </div>
        </div> 

        </form> 
        <div>

    </div>
    </div>
</div>