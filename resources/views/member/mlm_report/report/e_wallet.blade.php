<div class="col-md-12 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-primary"><i class="fa fa-money"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">E-Wallet Report</span>
      <span class="info-box-number">Per Slot</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div> 
<br>
<br>
<br>
<br>
<br>
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
        	<div style="overflow-x:auto;">
        		<table class="table table-condensed table-bordered">
        			<thead >
        				<th>Slot</th>
                        @foreach($plan as $key => $value)
                        <th>
                           
                            @if(isset($plan_settings[$key]))
                                {{$plan_settings[$key]->marketing_plan_label}}
                            @else
                                {{$key}}
                            @endif

                        </th>
                        @endforeach
                        <th>Current</th>
        			</thead>
        			<tbody>
        				@foreach($per_complan as $key => $value)
                        <?php $current = 0; ?>
                            <tr>
                                <td>
                                    <a href="javascript:" class="popup" link="/member/mlm/slot/view/{{$key}}" size="lg">
                                    @if(isset($slot[$key]))
                                        {{$slot[$key]->slot_no}}
                                    @else
                                        {{$key}}
                                    @endif
                                    </a>
                                </td>
                                @foreach($plan as $key2 => $value2)
                                    @if(isset($value[$key2]))
                                        <td>{{$value[$key2]}}</td>
                                        <?php $current += $value[$key2]; ?>
                                    @else
                                        <td>0</td>
                                    @endif
                                @endforeach
                                <td>
                                    {{$current}}
                                </td>
                            </tr>
        				@endforeach
        			</tbody>
        		</table>
        	</div>
        </div>
    </div>
</div>    