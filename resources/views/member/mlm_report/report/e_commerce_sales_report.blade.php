<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <div class="load-data" target="target_paginate_e_wallet_report" report_choose="e_commerce_sales_report" from="paginate">
                <div id="target_paginate_e_wallet_report">
                    <div style="overflow-x:auto;">
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Item Order</th>                                   
                                    <th>Date</th>  
                                    <th>Customer</th>  
                                    <th>Payment Status</th>  
                                    <th>Billing Address</th>                           
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($_arr_record as $_record)
                                    @foreach($_record as $key => $value)
                                        <tr>
                                            <td>{{ $value['ec_order_id'] }}</td>
                                            <td>{{ $value['eprod_name'] }}</td>
                                            <td>{{ $value['created_date'] }}</td>
                                            <td>{{ $value['full_name'] }}</td>
                                            <td>{{ $value['payment_status'] }}</td>
                                            <td>{{ $value['billing_address'] }}</td>
                                            <td>{{ $value['subtotal'] }}</td>
                                        </tr>
                                    @endforeach                                   
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        	
        </div>
    </div>
</div>    