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
          <div class="row clearfix">
            <div class="col-md-3">
              <div class="holder">
                <div class="img"><img src="/assets/mlm/img/payment/paypal.jpg"></div>
                <div class="name">
                  <div class="radio">
                    <label><input type="radio" name="payment_type" value="paypal"> PAYPAL</label>
                  </div>
                </div>
                <div class="desc">To: payment facility portal.</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="holder">
                <div class="img"><img src="/assets/mlm/img/payment/credit-card.jpg"></div>
                <div class="name">
                  <div class="radio">
                    <label><input type="radio" name="payment_type" value="credit"> Credit Card</label>
                  </div>
                </div>
                <div class="desc">To: payment facility portal.</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="holder">
                <div class="img"><img src="/assets/mlm/img/payment/bank-deposit.jpg"></div>
                <div class="name">
                  <div class="radio">
                    <label><input type="radio" name="payment_type" value="bank"> Bank Deposit</label>
                  </div>
                </div>
                <div class="desc">
                  <div class="desc-holder">
                    <div class="desc-label">Choose your bank</div>
                    <div class="desc-value">
                      <select class="form-control input-lg">
                        <option>BANK NAME</option>
                      </select>
                    </div>
                  </div>
                  <div class="desc-holder">
                    <div class="desc-label">Bank Account No.</div>
                    <div class="desc-value">
                      <input class="form-control input-lg" type="text" value="XXXX-XXXX-XXXX" name="">
                    </div>
                  </div>
                  <div class="desc-holder">
                    <div class="desc-label">Upload Proof of Payment</div>
                    <div class="desc-value">
                      <button class="btn btn-default input-lg" disabled="">UPLOAD</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="holder">
                <div class="img"><img src="/assets/mlm/img/payment/bank-deposit.jpg"></div>
                <div class="name">
                  <div class="radio">
                    <label><input type="radio" name="payment_type" value="membership_code"> Membership Code</label>
                  </div>
                </div>
                <div class="desc">
                  <div class="desc-holder">
                    <div class="desc-label">Membership Pin</div>
                    <div class="desc-value">
                      <input class="form-control input-lg" type="text" value="" name="membership_pin">
                    </div>
                  </div>
                  <div class="desc-holder">
                    <div class="desc-label">Membership Code</div>
                    <div class="desc-value">
                      <input class="form-control input-lg" type="text" value="" name="membership_code">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <h3 class="text-left" style="margin-top: 100px;">Cart Summary</h3>
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
</script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/assets/mlm/css/register-payment.css">
@endsection