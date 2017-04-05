<div class="col-md-12 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-primary"><i class="fa fa-cart-arrow-down"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Membership Sale Report / Package</span>
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
                            <th>Invoice ID</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Date</th>  
                            <th>Amount</th>
                        </thead>
                        <tbody>
                            @foreach($invoice as $key => $value)
                            <tr>
                                <td>{{$value->membership_code_invoice_id}}</td>
                                <td>{{$value->membership_code_customer_email}}</td>
                                <td>{{$value->membership_code_invoice_f_name}} {{$value->membership_code_invoice_m_name}} {{$value->membership_code_invoice_l_name}}</td>
                                <td>{{$value->membership_code_date_created}}</td>
                                <td class="change_currency">{{$value->membership_total}}</td>
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
      <span class="info-box-text">Membership Sale Report / Package</span>
      <span class="info-box-number">Per Package</span>
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
                            <th>Package</th>
                            <th>Amount</th>
                        </thead>
                        <tbody>
                            @foreach($by_membership as $key => $value)
                            <tr>
                                <td class="">
                                    @if(isset($package[$key]))
                                    {{$package[$key]->membership_package_name}}
                                    @else
                                    {{$key}}
                                    @endif

                                </td>
                                <td class="change_currency">
                                    {{$value}}
                                </td>
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
      <span class="info-box-text">Membership Sale Report / Package</span>
      <span class="info-box-number">Per Package Item</span>
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
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Bundle Quantity</th>
                        </thead>
                        <tbody>
                            @foreach($package_item as $key => $value)
                            <tr>
                                <td>{{$key}}</td>
                                <td>{{$value['item_quantity']}}</td>
                                <td>{{$value['item_bundle_quantity']}}</td>
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
<script type="text/javascript">
    show_currency();
</script>
