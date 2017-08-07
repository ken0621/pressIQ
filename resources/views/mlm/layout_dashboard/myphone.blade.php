@extends('mlm.layout')
@section('content')
   @if($slot_start_status)
      {!! $slot_start_status !!}
   @else
   <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header">
          <center>Matrix Per Level</center>
        </div>
        <div class="box-body">
          
          <table class="table">
            <th>Level</th>
            <th>Count</th>
            <th>Percentage</th>

            @foreach($count_per_level as $key => $value)
              <tr class="width_tr_a" percentage="@if(isset($tree_count[$key])){{($tree_count[$key]->count_slot/$value) * 100}}@else{{0}}@endif">
                <td>{{$key + 1}}</td>
                <td>@if(isset($tree_count[$key])) {{$tree_count[$key]->count_slot}}/{{$value}} @else 0/{{$value}} @endif</td>
                <td>@if(isset($tree_count[$key])){{($tree_count[$key]->count_slot/$value) * 100}}@else{{0}}@endif %</td>
              </tr>
            @endforeach

          </table>
        </div>
      </div>
    </div>
     <div class="col-md-4">
        <div class="box box-primary">
          <div class="box-body">
            <canvas id="doughnut-chart" width="800" height="450"></canvas>
          </div>
        </div>
      </div>
    
      @if(isset($new_member))
      <div class="col-md-4">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">New Referral</h3>

            <div class="box-tools pull-right">
              <span class="label label-success">{{count($new_member)}} New Members</span>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">

            <ul class="users-list ">
                @if(count($new_member) >= 1)
                    @foreach($new_member as $key => $value)
                        <li class="clearfix"
                        style="width: 50% !important">
                            {{name_format_from_customer_info($value)}}
                          <span class="users-list-date">{{$value->slot_created_date}}</span>
                        </li>
                    @endforeach
                @else
                  <li class="clearfix" style="width: 100% !important">
                    <center>---No referral---</center>
                  </li>
                @endif
            </ul>
            <!-- /.users-list -->
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      @endif

      <div class="col-md-8 ">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Recent Activities</h3>
            </div>
            <div class="box-body clearfix">
                <div class="dashboard-widget-content">
                   <ul class="list-unstyled timeline widget">
                      <li>
                         <div class="block">
                            <div class="block_content">
                              @if(count($recent_activity) >= 1)
                                 @foreach($recent_activity as $key => $value)
                                 <h2 class="title">
                                    <a>{{$value->wallet_log_details}}</a>
                                 </h2>
                                 <div class="byline">
                                    <span>{{$value->ago}}</span>
                                 </div>
                                 <p class="excerpt"> Wallet Amount: {{$value->wallet_log_amount}}<a class="hide">Details</a>
                                 </p>
                                 @endforeach
                              @else
                                <h2 class="title">
                                    No Recent Activity
                                </h2>
                                <div class="byline">
                                    <span>Now</span>
                                </div>
                              @endif 
                            </div>
                         </div>
                      </li>
                   </ul>
                </div>
            </div>
        </div>
      </div>
   @endif
@endsection
@section('js')
<script type="text/javascript">
new Chart(document.getElementById("doughnut-chart"), {
    type: 'doughnut',
    data: {
      labels: [ @if(count($income_per_complan) == 0) 'No Income Summary Available' @endif @foreach($income_per_complan as $key => $value) @if($value->wallet_log_amount >= 1 )"{{$complan[$value->wallet_log_plan]->marketing_plan_label}} {{currency('PHP', $value->wallet_log_amount)}}",@endif  @endforeach ],
      datasets: [
        {
          label: "Income",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: [ @if(count($income_per_complan) == 0) 0 @endif @foreach($income_per_complan as $key => $value) @if($value->wallet_log_amount>=1)"{{$value->wallet_log_amount}}",@endif @endforeach ],
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Income Summary'
      }
    }
});

$('.width_tr_a').each(function () {
    var percentage = $(this).attr('percentage');
    var col1="#B8CDD3";
    var col2="#EDEDED";
    var t = $(this);
    $(this).css('background', "-webkit-gradient(linear, left top,right top, color-stop("+percentage+"%,"+col1+"), color-stop("+percentage+"%,"+col2+"))");
    $(this).css('background',  "-moz-linear-gradient(left center,"+col1+" "+percentage+"%, "+col2+" "+percentage+"%)");
    $(this).css('background',  "-o-linear-gradient(left,"+col1+" "+percentage+"%, "+col2+" "+percentage+"%)");
    $(this).css('background',  "linear-gradient(to right,"+col1+" "+percentage+"%, "+col2+" "+percentage+"%)");
});


</script>
@endsection
@section('css')

@endsection