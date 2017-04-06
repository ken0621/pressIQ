<div class="col-md-12 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-primary"><i class="fa fa-cart-arrow-down"></i></span>

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


<div class="col-md-12 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-primary"><i class="fa fa-cart-arrow-down"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Product Sales Report</span>
      <span class="info-box-number">Per Invoice</span>
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
                            <th>Invoice Id</th>  
                            <th>Email</th>
                            
                            <th>Date</th>
                            <th>Subtotal</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Payment Type</th>
                            <th>Amount/Wallet/Gc</th>
                            <th>Change</th>
                        </thead>
                        <tbody>
                            @foreach($invoice as $key => $value)
                                <tr>
                                    <td>{{$value->item_code_invoice_id}}</td>
                                    <td>{{$value->item_code_customer_email}}</td>
                                    
                                    <td>{{$value->item_code_date_created}}</td>
                                    <td>{{currency('PHP', $value->item_subtotal)}}</td>
                                    <td>{{currency('PHP', $value->item_discount)}}</td>
                                    <td>{{currency('PHP', $value->item_total)}}</td>
                                    <td>
                                        
                                        <?php 
                                        switch ($value->item_code_payment_type) {
                                            case 1:
                                                echo 'CASH';
                                                break;
                                            case 2:
                                                echo 'GC';
                                                break;
                                            case 3:
                                                echo 'Wallet';
                                                break;
                                            
                                            default:
                                                echo 'CASH';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>{{currency('PHP', $value->item_code_tendered_payment)}}</td>
                                    <td>{{currency('PHP', $value->item_code_change)}}</td>
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