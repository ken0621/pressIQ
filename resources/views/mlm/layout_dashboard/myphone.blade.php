@extends('mlm.layout')
@section('content')
   @if($slot_start_status)
      {!! $slot_start_status !!}
   @else
   <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-body">
          <canvas id="doughnut-chart" width="800" height="450"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-body">
          <center>Matrix Per Level</center>
          <table class="table">
            <th>Level</th>
            <th>Count</th>

            @foreach($count_per_level as $key => $value)
              <tr>
                <td>{{$key}}</td>
                <td>@if(isset($tree_count[$key])) {{$tree_count[$key]->count_slot}}/{{$value}} @else 0/{{$value}} @endif</td>
              </tr>
            @endforeach

          </table>
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
      labels: [ @if(count($income_per_complan) == 0) 'No Income Summary Available' @endif @foreach($income_per_complan as $key => $value) "{{$complan[$value->wallet_log_plan]->marketing_plan_name}} {{currency('PHP', $value->wallet_log_amount)}}",  @endforeach ],
      datasets: [
        {
          label: "Income",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: [ @if(count($income_per_complan) == 0) 0 @endif @foreach($income_per_complan as $key => $value) "{{$value->wallet_log_amount}}", @endforeach ],
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
</script>
@endsection
@section('css')

@endsection