@extends("mlm.register.layout")
@section("content")
<div class="payment">
  <div class="container-fluid">
    <div class="title">How do you want to pay?</div>
    <div class="sub">Aenea commodo ligula eget dolor.</div>
    <div class="payment-container">
      <div class="row clearfix">
        <div class="col-md-4">
          <div class="holder">
            <div class="img"><img src="/assets/mlm/img/payment/paypal.jpg"></div>
            <div class="name">
              <div class="radio">
                <label><input type="radio" name="optradio"> PAYPAL</label>
              </div>
            </div>
            <div class="desc">To: payment facility portal.</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="holder">
            <div class="img"><img src="/assets/mlm/img/payment/credit-card.jpg"></div>
            <div class="name">
              <div class="radio">
                <label><input type="radio" name="optradio"> Credit Card</label>
              </div>
            </div>
            <div class="desc">To: payment facility portal.</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="holder">
            <div class="img"><img src="/assets/mlm/img/payment/bank-deposit.jpg"></div>
            <div class="name">
              <div class="radio">
                <label><input type="radio" name="optradio"> Bank Deposit</label>
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
                  <button class="btn btn-default input-lg">UPLOAD</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="information-container">
      <div class="information-title">Delivery Information</div>
      <div class="form-holder">
        <div class="row clearfix">
          <div class="col-md-6">
            <div class="form-group">
              <label>First Name</label>
              <input type="text" class="form-control input-lg" name="">
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" class="form-control input-lg" name="">
            </div>
            <div class="form-group">
              <label>Contact Information</label>
              <input type="text" class="form-control input-lg" name="">
            </div>
            <div class="form-group">
              <label>Other Contact Information</label>
              <input type="text" class="form-control input-lg" name="">
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
              <textarea class="form-control input-lg"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="button-holder">
      <button class="btn btn-green btn-lg">PROCEED</button>
    </div>
  </div>
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/assets/mlm/css/register-payment.css">
@endsection