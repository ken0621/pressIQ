@extends("mlm.register.layout")
@section("content")
<div class="package">
  <div class="container-fluid text-center">
    <div class="title">Create a Brown Package</div>
    <div class="sub">Aenea commodo ligula eget dolor.</div>
    <div class="membership">
      <div class="row clearfix">
      @if(count($membership) >= 0)
        @foreach($membership as $key => $value)
        <div class="col-md-4">
          <div class="holder">
            <div class="img">
              <img src="/assets/mlm/img/placeholder.jpg">
            </div>
            <div class="text-holder">
              <div class="name">
                <div class="radio">
                  <label><input type="radio" name="optradio"> {{$value->membership_name}}</label>
                </div>
              </div>
              <!-- <div class="membership-name">Silver Membership</div> -->
              <div class="membership-price">PHP 5,000.00</div>
              <div class="info">Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.</div>
              <div class="type">
                <select class="form-control input-lg">
                  @if($package[$key]->first())
                    @foreach($package[$key] as $key2 => $value2)
                    <option>{{$value2->membership_package_name}}</option>
                    @endforeach
                  @else
                    <option>NO PACKAGE AVAILABLE</option>
                  @endif
                </select>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      @else
        
      @endif  
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