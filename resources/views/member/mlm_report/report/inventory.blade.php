<div class="col-md-12 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-primary"><i class="fa fa-sitemap"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Product Sales Report</span>
      <span class="info-box-number">Per Item</span>
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
        			<thead>
        				<thead>
                            <th>Item Name</th>  
                            @foreach($filter as $key => $value)  
                                <th>{{$key}}</th> 
                            @endforeach
                        </thead>
                        <tbody>
                            @foreach($inventory as $key => $value)
                            <tr>
                                <td>{{$key}}</td>
                                @foreach($value as $key2 => $value2)
                                <td>
                                    {{$value2}}
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
        			</thead>
        			<tbody>
        			</tbody>
        		</table>
        	</div>
        </div>
    </div>
</div>    