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
<?php $grand_total = 0; ?>
@foreach($sales as $key => $value)
<?php 
    $sub_total = 0;
?>
<div class="panel panel-default panel-block panel-title-block col-md-4" id="top">
    <div class="panel-heading">
        <div>
            
            <table class="table table-condensed table-bordred">
                <th>{{$value}}</th>
                <th>Amount</th>
    
                
                @foreach($warehouse as $w_key => $w_val)
<<<<<<< HEAD
                <tr>
                    <td>{{$w_val->warehouse_name}}</td>
                    <td>{{currency('PHP', $w_val->$key)}}</td>
                </tr>
                <?php 
                    $sub_total += $w_val->$key; 
                    $grand_total +=  $sub_total;
                ?>
=======
                    @if($key == 'e_wallet_transfer' || $key == 'e_wallet_tours')
                        @if($w_val->main_warehouse == 1)
                            <tr>
                                <td>PHILTECH MAIN OFFICE</td>
                                <td>{{currency('PHP', $w_val->$key)}}</td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td>{{$w_val->warehouse_name}}</td>
                            <td>{{currency('PHP', $w_val->$key)}}</td>
                        </tr>
                     @endif
                    <?php 
                        $sub_total += $w_val->$key; 
                    ?>
>>>>>>> master
                @endforeach
                <tr>
                    <td><span class="pull-right"><small>SUBTOTAL:</small></span></td>
                    <td>{{currency('PHP', $sub_total)}}</td>
<<<<<<< HEAD

=======
                <?php 
                    $grand_total +=  $sub_total;
                ?>
>>>>>>> master
                </tr>
                
            </table>
            
        </div>
    </div>
</div>   
      
@endforeach
<<<<<<< HEAD
<div class="panel panel-default panel-block panel-title-block col-md-4" id="top">
=======
<div class="panel panel-default panel-block panel-title-block col-md-12" id="top">
>>>>>>> master
    <div class="panel-heading">
        <div>
            <table class="table">
                <tr>
<<<<<<< HEAD
                    <th><span class="pull-right">Grand Total :</span> </th>
                    <th>{{currency('PHP', $grand_total)}}</th>
                </tr>
=======
                    <th><span class="pull-right">Grand Total: </span></th>
                    <th>{{currency('PHP', $grand_total)}}</th>
                </tr>
                <tr>
                    <th><span class="pull-right">Overall Grand Total: </span></th>
                    <th>{{currency('PHP', $g_over_total)}}</th>
                </tr>
>>>>>>> master
            </table>
        </div>
    </div>
</div>   