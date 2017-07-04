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
        <h1>Paymaya Checkout Cross Reference</h1>
        <p class="lead title-count">This page allows to get corresponding checkout ID and status of payment.</p>
        <button class="pull-right btn btn-primary start-re-compute"> GET DATA FROM PAYMAYA </button>
      </div>
      
      <table class="table table-condensed table-bordered">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Paymaya <br>Log Date</th>
            <th>Ordered By</th>
            <th>E-Mail</th>
            <th>Invoice #</th>
            <th>Contact No</th>
            <th>Checkout ID</th>
            <th>Paymaya Response</th>
            <th>Response Information</th>
            <th>Slot</th>
            <th class="text-center">Investigation</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php $investigation_count = 0; ?>
        
          @foreach($_order as $order)
            @if(($order->confirm_response == "PAYMENT_SUCCESS" && $order->slot_id == "") || ($order->confirm_response != "PAYMENT_SUCCESS"  && $order->slot_id != ""))
            <tr class="tr-order {{ $order->confirm_response == '' || $order->confirm_response == 'PENDING' ? 'pending' : '' }}"  order_id="{{ $order->order_id }}" checkout_id="{{ $order->checkout_id }}">
              <th>{{ $order->ec_order_id }}</th>
              <th width="200px">{{ date("F d, Y  h:i A",strtotime($order->log_date)) }}</th>
              <th>{{ $order->first_name . " " . $order->last_name}}</th>
              <td>{{ $order->email }}</td>
              <td>{{ $order->invoice_number }}</td>
              <td>{{ $order->customer_mobile }}</td>
              <td>{{ $order->checkout_id }}</td>
              <td class="response">{{ $order->confirm_response }}</td>
              <td class="information">{{ $order->confirm_response_information }}</td>
              <td>{{ ($order->slot_id == "" ? "NO SLOT" : $order->slot_id) }}</td>
              <td style="color: red; text-center">
                  @if($order->confirm_response == "" || $order->confirm_response == "PENDING")
                      TRANSACTION PENDING (NOT CONCLUSIVE YET)
                  @elseif($order->confirm_response == "PAYMENT_SUCCESS" && $order->slot_id == "")
                      <?php $investigation_count++; ?>
                      PAYMENT SUCESSFUL BUT THERE IS NO SLOT
                  @elseif($order->confirm_response != "PAYMENT_SUCCESS"  && $order->slot_id != "")
                       <?php $investigation_count++; ?>
                      THERE IS A SLOT BUT PAYMENT HASN'T BEEN CONFIRMED
                  @endif
              </td>
              <td class="status text-center"></td>
            </tr>
            @endif
          @endforeach
        </tbody>
      </table>
      </div> <!-- /container -->
      <div style="font-size: 16px; margin: 30px; text-align: center;">TOTAL NO. OF CASE PROBLEM IS <br> <span style="color: red; font-size: 20px;">{{ $investigation_count }}</span></div>
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