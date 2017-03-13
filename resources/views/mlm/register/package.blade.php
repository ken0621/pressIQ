@extends("mlm.register.layout")
@section("content")
<div class="package">
  <div class="container-fluid text-center">
    <div class="title">Create a Brown Package</div>
    <div class="sub">Aenea commodo ligula eget dolor.</div>
    <div class="membership">
      <div class="row clearfix">
        <div class="col-md-4">
          <div class="holder">
            <div class="img">
              <img src="/assets/mlm/img/placeholder.jpg">
            </div>
            <div class="text-holder">
              <div class="name">
                <div class="radio">
                  <label><input type="radio" name="optradio"> Membership A</label>
                </div>
              </div>
              <div class="membership-name">Silver Membership</div>
              <div class="membership-price">PHP 5,000.00</div>
              <div class="info">Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.</div>
              <div class="type">
                <select class="form-control input-lg">
                  <option>PHONE A</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="holder">
            <div class="img">
              <img src="/assets/mlm/img/placeholder.jpg">
            </div>
            <div class="text-holder">
              <div class="name">
                <div class="radio">
                  <label><input type="radio" name="optradio"> Membership B</label>
                </div>
              </div>
              <div class="membership-name">Gold Membership</div>
              <div class="membership-price">PHP 10,000.00</div>
              <div class="info">Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.</div>
              <div class="type">
                <select class="form-control input-lg">
                  <option>PHONE A</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="holder">
            <div class="img">
              <img src="/assets/mlm/img/placeholder.jpg">
            </div>
            <div class="text-holder">
              <div class="name">
                <div class="radio">
                  <label><input type="radio" name="optradio"> Membership C</label>
                </div>
              </div>
              <div class="membership-name">Platinum Membership</div>
              <div class="membership-price">PHP 15,000.00</div>
              <div class="info">Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.</div>
              <div class="type">
                <select class="form-control input-lg">
                  <option>PHONE A</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="button-holder">
      <button class="btn btn-green btn-lg">PROCEED TO PAYMENT</button>
    </div>
  </div>
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/assets/mlm/css/register-package.css">
@endsection