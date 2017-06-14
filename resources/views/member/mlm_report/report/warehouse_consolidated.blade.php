<div class="col-md-12 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-primary"><i class="fa fa-money"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Warehouse Sales Report</span>
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
<?php 
    $sub_total = 0;
?>
@foreach($sales as $key => $value)
<div class="panel panel-default panel-block panel-title-block col-md-4" id="top">
    <div class="panel-heading">
        <div>
            
            <table class="table table-condensed table-bordred">
                <th>{{$value}}</th>
                <th>Amount</th>
    
                
                @foreach($warehouse as $w_key => $w_val)
                <tr>
                    <td>{{$w_val->warehouse_name}}</td>
                    <td>{{currency('PHP', $w_val->$key)}}</td>
                </tr>
                <?php $sub_total += $w_val->$key; ?>
                @endforeach
                <tr>
                    <td><span class="pull-right"><small>SUBTOTAL:</small></span></td>
                    <td>{{currency('PHP', $sub_total)}}</td>
                </tr>
                
            </table>
            
        </div>
    </div>
</div>    
@endforeach