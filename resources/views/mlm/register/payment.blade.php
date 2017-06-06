@extends("mlm.register.layout")

@section("content")
<form method="post" class="register-submit" action="/member/register/payment/submit" >
    {!! csrf_field() !!}
<div class="payment">
  <div class="container-fluid">
    <div class="title">How do you want to pay?</div>
    <div class="sub">Aenea commodo ligula eget dolor.</div>
    <div class="row clearfix">
      <div class="col-md-9">
        <div class="payment-container">
          <h2>Choose Payment Method</h2>
          @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          <div class="row clearfix">
            <div class="col-md-8">
              <div class="holder-holder">
                @if(count($_payment_method) != 0)
                  @foreach($_payment_method as $payment_method)
                    <div class="choose-payment-method holder" method_id="{{ $payment_method->method_id }}" description="{{ $payment_method->link_description }}">
                      <div class="match-height" style="line-height: 12.5px;">{{ $payment_method->method_name }}</div>
                      <div class="image" style="margin-top: 7.5px;">
                        <img src="{{ $payment_method->image_path ? $payment_method->image_path : '/assets/front/img/default.jpg' }}">
                      </div>
                      <div class="radio" style="margin-bottom: 0;">
                        <label >
                            <input class="radio" type="radio" name="payment_method_id" value="{{ $payment_method->method_id }}">
                        </label>
                      </div>
                    </div>
                  @endforeach 
                @else
                  <div class="text-center"><h3>No Payment Method Available</h3></div>
                @endif
              </div>
              <div class="details clearfix">
                <div class="detail-holder">
                  {{-- <div class="details-title">Upload Proof of Payment</div>
                  <button class="btn btn-primary" id="upload-button" type="button" onClick="$('.payment-upload-file').trigger('click');">UPLOAD</button>
                  <input onChange="$('.upload-name').text($(this).val().split('\\').pop());" class="hide payment-upload-file" type="file" name="payment_upload">
                  <div class="upload-name"></div> --}}
                  <div class="details-text">Kindly choose a payment method which you are most comfortable with paying.</div>
                  <div class="details-order">
                    <button class="btn btn-primary">PLACE YOUR ORDER</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>Product</th>
              <th>QTY</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Product Name</td>
              <td>1</td>
              <td>123</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td></td>
              <td>Subtotal</td>
              <td>P 1,000.00</td>
            </tr>
            <tr>
              <td></td>
              <td>Shipping Fee</td>
              <td>P 1,000.00</td>
            </tr>
            <tr>
              <td></td>
              <td>Total</td>
              <td>P 1,000.00</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- <div class="information-container">
      <div class="information-title">Delivery Information</div>
      <div class="form-holder">
        <div class="row clearfix">
          <div class="col-md-6">
            <div class="form-group">
              <label>First Name</label>
              <input type="text" class="form-control input-lg" name="first_name">
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" class="form-control input-lg" name="last_name">
            </div>
            <div class="form-group">
              <label>Contact Information</label>
              <input type="text" class="form-control input-lg" name="contact_info">
            </div>
            <div class="form-group">
              <label>Other Contact Information</label>
              <input type="text" class="form-control input-lg" name="contact_other">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Shipping Method</label>
              <select class="form-control input-lg">
                <option></option>
              </select>
            </div>
            <div class="form-group">
              <label>Complete Shipping Address</label>
              <textarea class="form-control input-lg" name="shipping_address"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <div class="button-holder">
      <button class="btn btn-green btn-lg">PROCEED</button>
    </div>
  </div>
</div>
</form>
@endsection
@section('script')
<script type="text/javascript">
event_choose_payment_method();
  $(document).on("submit", ".register-submit", function(e)
        {
            var data = $(e.currentTarget).serialize();
            var link = $(e.currentTarget).attr("action");
            $('#load').removeClass('hide');
            submit_form_register(link, data);
            e.preventDefault();
            
        })
  function submit_form_register(link, data)
    {
        
        $.ajax({
            url:link,
            dataType:"json",
            data:data,
            type:"post",
            success: function(data)
            {
              $('#load').addClass('hide');
              if(data.status == 'warning')
              {
                var message = data.message;
                $.each( message, function( index, value ){
              toastr.warning(value);
          });
              }
              else if(data.status == 'success')
              {
            window.location = data.link;                
              }
            },
            error: function()
            {
                $('#load').addClass('hide');
            }
        })
    }
    $('.match-height').matchHeight();
    $('input[name="payment_type"]').removeProp("checked");
    $('input[name="payment_type"]').removeAttr("checked");
    $('input[name="payment_type"]').change(function(event) 
    {
      var payment_type = $(event.currentTarget).val();

      if(payment_type == "dragonpay")
      {
        $('form').removeClass('register-submit');
      }
      else
      {
        $('form').addClass('register-submit');
      }
    });

   function event_choose_payment_method()
   {
      $(".choose-payment-method").unbind("click");
      $(".choose-payment-method").bind("click", function(e)
      {
         $(".checkout-summary .loader-here").removeClass("hidden");
         $(e.currentTarget).find(".radio").prop("checked", true);

         var description = $(e.currentTarget).attr("description");
         $(".details-text").html(description);

         var method_id = $(e.currentTarget).attr("method_id");
      });
   }
</script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/assets/mlm/css/register-payment.css">
<link rel="stylesheet" href="/themes/ecommerce-1/css/checkout_payment.css">
@endsection