
<div class="col-md-12 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-primary"><i class="fa fa-money"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">COMPLAN INCOME REPORT</span>
      <span class="info-box-number">Per Day</span>
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
        	<div class="table-reponsive">
        		<table class="table table-condensed table-bordered">
        			<thead>
        				<th>Day</th>
        				<th>PLAN</th>
        				<th>Amount</th>
        			</thead>
        			<tbody>
        				@foreach($per_day as $key => $value)
	        				@foreach($value as $key2 => $value2)
	        				<tr>
	        					<td>{{$key}}</td>
	        					<td>{{$key2}}</td>
	        					<td>{{$value2}}</td>
	        				</tr>
	        				@endforeach
        				@endforeach
        			</tbody>
        		</table>
        	</div>
        </div>
    </div>
</div>      
<div class="col-md-12 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-primary"><i class="fa fa-money"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">COMPLAN INCOME REPORT</span>
      <span class="info-box-number">Per Month</span>
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
        	<div class="table-reponsive">
        		<table class="table table-condensed table-bordered">
        			<thead>
        				<th>Month</th>
        				<th>PLAN</th>
        				<th>Amount</th>
        			</thead>
        			<tbody>
        				@foreach($per_month as $key => $value)
	        				@foreach($value as $key2 => $value2)
	        				<tr>
	        					<td>{{$key}}</td>
	        					<td>

	        					
	        					@if(isset($plan_settings[$key2]))
	        					{{$plan_settings[$key2]->marketing_plan_label}}
	        					@else
	        					{{$key2}}
	        					@endif
	        					</td>
	        					<td>{{$value2}}</td>
	        				</tr>
	        				@endforeach
        				@endforeach
        			</tbody>
        		</table>
        	</div>
        </div>
    </div>
</div>      

<div class="col-md-12 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-primary"><i class="fa fa-money"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">COMPLAN INCOME REPORT</span>
      <span class="info-box-number">Per Year</span>
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
        	<div class="table-reponsive">
        		<table class="table table-condensed table-bordered">
        			<thead>
        				<th>Month</th>
        				<th>PLAN</th>
        				<th>Amount</th>
        			</thead>
        			<tbody>
        				@foreach($per_year as $key => $value)
	        				@foreach($value as $key2 => $value2)
	        				<tr>
	        					<td>{{$key}}</td>
	        					<td>

	        					
	        					@if(isset($plan_settings[$key2]))
	        					{{$plan_settings[$key2]->marketing_plan_label}}
	        					@else
	        					{{$key2}}
	        					@endif
	        					</td>
	        					<td>{{$value2}}</td>
	        				</tr>
	        				@endforeach
        				@endforeach
        			</tbody>
        		</table>
        	</div>
        </div>
    </div>
</div>    