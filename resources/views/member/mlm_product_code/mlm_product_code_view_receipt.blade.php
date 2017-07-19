
    <!-- NO PRODUCT YET -->
    <div class="clearfix">
        <div>
            <div class="row clearfix">
                <table class="table">
                    <tr>
                        <td style="border-right: 2.5px solid #1E5649; padding-bottom: 20px;">
                            <div class="row clearfix">
                                <div class="col-md-12" >
                                <!-- style="background-color: #24267A;" -->
                                @if($company_logo != null)
                                     <div class="item">
                                         <center><img src="@if(Request::input('pdf') == 'true'){{public_path().$company_logo}} @else {{$company_logo}}@endif" alt="" style="object-fit: cover; width: 100% "></center>
                                     </div>
                                @else 
                                    <div class="item">
                                         <center><img src="@if(Request::input('pdf') == 'true'){{public_path().'/assets/philtech-official-logo.png'}} @else {{'/assets/philtech-official-logo.png'}}@endif" alt="" style="object-fit: cover; width: 100% " ></center>
                                     </div>
                                @endif    
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-12" style="font-weight: bold;">{{$company_name}}</div>
                                    <div class="col-md-12">Address: {{$shop_address}}</div>
                                    <div class="col-md-12">Phone: {{$shop_contact}}</div>
                                    <div class="col-md-12">Email: {{$company_email}}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12" style="margin-left:21px;">
                                <span style="font-size: 40px; color:#f1c40f; font-weight: bold;">RECEIPT</span></div>
                                <div class="col-md-12" style="margin-left:24px;">
                                    Date:
                                    <span class="underlined_text">
                                        {{$invoice->item_code_date_created}}
                                    </span>
                                </div>
                                <div class="col-md-12" style="margin-left:24px;">
                                    Invoice #:
                                    <span class="underlined_text_2">
                                    @if($invoice->item_code_invoice_number == null)
                                        
                                        <center>{{$invoice->item_code_invoice_id}}</center>
                                    @else
                                        
                                        <center>{{$invoice->item_code_invoice_number}}</center>
                                    @endif    
                                    </span>
                                </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12" style="border-top: 5px solid #1E5649;">
                <div class="tab-content codes_container">
                    <div id="all" class="tab-pane fade in active">
                        <div class="form-group order-tags"></div>
                        <div class="table-responsive">
                            <table class="table table-condensed">                        
                                    <tr>
                                        <td rowspan="4" class="bill-title col-md-2">V.I.P. Member</td>
                                    </tr>                        
                                    <tr>                                
                                        <td>Name: {{name_format_from_customer_info($invoice)}}</td>
                                    </tr>
                                    @if(isset($slot->slot_no))
                                    <tr>
                                        <td>Slot: {{$slot->slot_no}}</td>
                                    </tr>   
                                    @endif
                                    <tr>                                
                                        <td>Email:{{$invoice->email}}</td>
                                    </tr>    
                                                     
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12" style="margin-top:25px;">
                <table class="table table-condensed tadble">     
                    <thead>                   
                            <tr>
                                <th>Item Name</th>
                                <th>Code</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Original <br>Price</th>
                                <th>V.I.P. <br>Price</th>
                            </tr>   
                    </thead>    
                    <tbody>
                    @if(isset($item_list))
                        @foreach($item_list as $key => $value)
                        <tr>
                            <td>{{$value->item_name}}</td>
                            <td>{{$value->item_activation_code}}</td>
                            <td>{{$value->item_price}}</td>
                            <td>{{$value->item_quantity}}</td>
                            <td>{{$value->item_price * $value->item_quantity}}</td>
                            <td>{{$value->item_membership_discounted * $value->item_quantity}}</td>
                        </tr>
                        @if($value->item_serial != null)
                        <tr>
                            <td colspan="2"><span class="pull-right">Serial/s:</span></td>
                            <td colspan="3">{{$value->item_serial}}</td>
                        </tr>
                        @endif
                        @endforeach
                    @else
                    <tr>
                        <td colspan="40"><center></center></td>
                    </tr>    
                    @endif    
                    </tbody>               
                </table>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12" style="margin-top:25px;">
                <table class="table table-condensed tadble">     
                    <thead>                   
                            <tr class="hide">
                                <th>Code ID</th>
                                <th>Activation Code</th>
                                <th>Used on slot</th>
                                <th>Date Used</th>
                            </tr>   
                    </thead>   
                    <tbody>
                        <?php $sum_points = 0; ?>
                        @foreach($_code as $code)
                            <tr class="hide">                                
                                <td>{{$code->item_code_id}}</td>
                                <td>{{$code->item_activation_code}}</td>
                                <td>{{$code->slot_no}}</td>
                                <td>{{$code->date_used}}</td>
                            </tr>    
                            <?php if(isset($code->REPURCHASE_POINTS)){ 
                                $sum_points += $code->REPURCHASE_POINTS;
                            }  ?>
                        @endforeach
                        <tr>
                            <td style="vertical-align: top !important; padding: 0;" colspan="2">
                                <textarea class="form-control" style="height:auto; resize: none;" disabled>
                                    {{$invoice->item_code_statement_memo}}
                                </textarea>
                            </td>
                            <td style="vertical-align: top !important; padding: 0; border: 0 !important;" colspan="2">
                                <table style="width: 100%; border-top: 0;">  
                                    @if($sum_points != 0)
                                    <tr>
                                        <td>Total Points (Repurchase): </td>
                                        <td>{{$sum_points}}</td>
                                    </tr>    
                                    <tr>
                                        <td colspan="2">
                                            <hr>
                                        </td>
                                    </tr>             
                                    @endif 
                                    <tr>
                                        <td>Subtotal</td>
                                        <td>{{$subtotal}}</td>
                                    </tr>   
                                    <tr>                                
                                        <td>Discount</td>
                                        <td>{{$discount_amount}}</td>
                                    </tr>   
                                    <tr>                                
                                        <td>Total</td>
                                        <td>{{$total}}</td>
                                    </tr> 

                                    <tr>
                                        <td colspan="2">
                                            <hr>
                                        </td>
                                    </tr>     
                                    <tr>
                                        <td>Payment :</td>
                                        <td>
                                            <?php
                                            $label = 'Tendered Amount';
                                            $label_change = 'Change';
                                            switch ($invoice->item_code_payment_type) {
                                                case 1:
                                                    echo 'Cash'; 
                                                    break;
                                                case 2:
                                                    echo 'GC';
                                                    $label = 'GC Amount';
                                                    $label_change = 'GC Change';
                                                    break;  
                                                case 3:
                                                    echo 'Wallet';
                                                    $label = 'Current Wallet';
                                                    $label_change = 'Remaining Wallet';
                                                    break;        
                                                default:
                                                    echo 'Cash';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{$label}} :</td>
                                        <td>{{number_format($invoice->item_code_tendered_payment, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$label_change}} :</td>
                                        <td>{{number_format($invoice->item_code_change, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                        <center>
                                            <br>
                                            <br>
                                            ______________________________________<br>
                                            Authorized Signature over printed name
                                        </center>
                                        </td>
                                    </tr>                                 
                                </table>
                            </td>
                        </tr>                    
                    </tbody>                  
                </table>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12 text-center">
                <p>-End-</p>
            </div>
        </div>
    </div>       

<style type="text/css">
    .tadble thead tr th
    {
        background-color: #1E5649;
        color: #fff;
    }
    .tadble
    {
        border-collapse: collapse;
    }
    .tadble th, .tadble td
    {
        border: 1px dotted #1E5649 !important;
    }
    .underlined_text
    {
        display: inline-block; 
        line-height: 0.9; 
        border-bottom: 1px dotted; 
        min-width: 159px;
    }

    .underlined_text_2
    {
        display: inline-block; 
        line-height: 0.9; 
        border-bottom: 1px dotted; 
        min-width: 160px;
    }
    .bill-title
    {
        background-color: #BFBFBF;
        text-align: center;
        min-width: 100px;
        font-size: 25px;
        font-weight: bold;
    }

</style>