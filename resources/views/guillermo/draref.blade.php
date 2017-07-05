<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Grid Template for Bootstrap</title>
    <!-- Bootstrap core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


    <!-- Custom styles for this template -->
    <link href="grid.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="">
      <div class="page-header">
        <h1>Dragonpay Checkout Cross Reference</h1>
        <p class="lead title-count">This page allows to get corresponding checkout ID and status of payment.</p>
        <!--<button class="pull-right btn btn-primary start-re-compute"> GET DATA FROM PAYMAYA </button>-->
      </div>
      <div style="white-space: nowrap">
      <table class="table table-condensed table-bordered" style="display: inline-block;">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Paymaya <br>Log Date</th>
            <th>Ordered By</th>
            <th>E-Mail</th>
            <th>Invoice #</th>
            <th>Invoice Date</th>
            <th>Contact No</th>
            <th>Birthday</th>
            <th>Street</th>
            <th>Zip</th>
            <th>City</th>
            <th>State</th>
            <th>TXN ID</th>
            <th>Slot</th>
            <th class="text-center">Investigation</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php $investigation_count = 0; ?>
        @foreach($_order as $order)
          @if($order->slot_id != "")
          <tr class="tr-order"  order_id="{{ $order->order_id }}">
            <th>{{ $order->ec_order_id }}</th>
            <th width="200px">{{ date("F d, Y  h:i A",strtotime($order->log_date)) }}</th>
            <th>{{ $order->first_name . " " . $order->last_name}}</th>
            <td>{{ $order->email }}</td>
            <td>{{ $order->invoice_number }}</td>
            <td width="200px">{{ date("F d, Y  h:i A",strtotime($order->slot_created_date)) }}</td>
            <td>{{ $order->customer_mobile }}</td>
            <td>{{ date('M d, Y',strtotime($order->b_day)) }}</td>
            <td>{{ $order->customer_street }}</td>
            <td>{{ $order->customer_zipcode }}</td>
            <td>{{ $order->customer_city }}</td>
            <td>{{ $order->customer_state }}</td>
            <td>{{ unserialize($order->response)["txnid"] }}</td>
            <td>{!! ($order->slot_id == "" ? "NO SLOT" : "<span style='color: green'>$order->slot_id</span>") !!}</td>
            <td class="status text-center"></td>
          </tr>
          @endif
        @endforeach
        </tbody>
      </table>
      </div>
      </div> <!-- /container -->
      
        <!-- Latest compiled and minified JavaScript -->
      <script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
       
        <script type="text/javascript">
            $(".start-re-compute").click(function(e)
            {
                compute($(".tr-order.pending:first").attr("order_id"));
            });
            
            
            function compute($order_id)
            {
                $(".title-count").html("Computing Order No." + $order_id);
                $last_id = parseInt($(".tr-order:last").attr("order_id"));
                if(parseInt($order_id) > $last_id)
                {
                    alert("Payamaya details updated successfully.");
                }
                else if($(".tr-order[order_id=" + $order_id + "]").hasClass("pending"))
                {
                    $checkout_id = $(".tr-order[order_id=" + $order_id + "]").attr("checkout_id");
                    
                    $.ajax(
                    {
                        url:"/member/payref/" + $checkout_id + "?order_id=" + $order_id,
                        dataType:"json",
                        type:"get",
                        success: function(data)
                        {
                               $(".tr-order[order_id=" + $order_id + "]").find(".response").html(data.response);
                               $(".tr-order[order_id=" + $order_id + "]").find(".information").html(data.information);

                            $(".tr-order[order_id=" + $order_id + "]").find(".status").html('<i style="color: green;" class="glyphicon glyphicon-check"></i>');
                            setTimeout(function()
                            {
                                compute(parseInt($order_id) + 1);
                            }, 100)
                            
                        }
                    });
                }
                else
                {
                    setTimeout(function()
                    {
                        compute(parseInt($order_id) + 1);
                    }, 100)
                }
                
                return 0;
            }
        </script>
    </body>
</html>