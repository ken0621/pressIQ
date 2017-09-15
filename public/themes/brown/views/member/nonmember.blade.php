@extends("member.member_layout")
@section("member_content")
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}">
<div class="dashboard">

  <!-- TOP DASHBOARD-->
  <div class="dashboard-top">
      <div class="row clearfix">
        <div class="col-md-8">
          <div class="img-container">
            <img src="/themes/{{ $shop_theme }}/img/brown-img1.png">
          </div>
        </div>
        <div class="col-md-4">
        <div class="join-container">
          <div class="btn-text">
            <div class="text-header1">Join the Movement!</div>
            <div class="text-header2">Enroll now and become one of us!</div>
          </div>
          <div class="btn-container">
            <a href="#" id="btn-buy-a-kit"><button class="btn-buy-a-kit">Buy a Kit</button></a><br>
            <img src="/themes/{{ $shop_theme }}/img/or.png"><br>
            <a href="#" id="btn-enter-a-code"><button class="btn-enter-a-code">Enter a Code</button></a>
          </div>
        </div>
      </div>
      </div>
    </div>

  <!-- BOTTOM DASHBOARD -->
  <div class="dashboard-bottom">

      <div class="text-header">Profile Information</div>

      <div class="row clearfix">

            <div class="col-md-4 col-sm-6">
              <div class="profile-info-container pic1">
                <div class="icon-container">

                  <div class="col-md-2">
                    <img src="/themes/{{ $shop_theme }}/img/brown-personal-info.png">
                  </div>

                  <div class="col-md-10">
                    <div class="prof-info-text-header">Personal Information</div>
                  </div>
              
                </div>

                <div class="personal-info-container">

                  <div><label>Name </label><span>Lorem Ipsum Dolor</span></div>
                  <div><label>Email </label><span>Lorem Ipsum Dolor</span></div>
                  <div><label>Birthday </label><span>Lorem Ipsum Dolor</span></div>
                  <div><label>Contact </label><span>Lorem Ipsum Dolor</span></div>

                </div>
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="profile-info-container pic2">
                <div class="icon-container">

                  <div class="col-md-2">
                      <img src="/themes/{{ $shop_theme }}/img/brown-default-shipping.png">
                  </div>

                  <div class="col-md-10">
                      <div class="prof-info-text-header">Default Shipping Address</div>
                  </div>

                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae similique nulla amet illum labore nostrum sapiente fugiat, pariatur ipsa distinctio.</p>
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="profile-info-container pic3">
                <div class="icon-container">

                <div class="col-md-2">
                   <img src="/themes/{{ $shop_theme }}/img/brown-default-billing.png">
                </div>

                <div class="col-md-10">
                  <div class="prof-info-text-header">Default Billing Address</div>
                </div>

                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos quibusdam nesciunt, dolor culpa architecto enim ratione error ipsum, animi sunt.</p>
              </div>
            </div>
        </div>
  </div>

  <!--   POPUPS -->

  <!-- Buy a Kit -->
  <div class="popup-buy-a-kit">
      <div id="buy-a-kit-modal" class="modal fade">
          <div class="modal-size modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><img src="/themes/{{ $shop_theme }}/img/cart.png"> My Shopping Cart</h4>
                  </div>
                  
                  <div>
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Remove</th>
                          <th>Image</th>
                          <th>Product Name</th>
                          <th>Unit Price</th>
                          <th width="160px">Quantity</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="remove-holder">
                            <a href="javascript:"><img src="/themes/{{ $shop_theme }}/img/remove.png"></a>
                          </td>
                          <td class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/wishlist-1.jpg">
                          </td>
                          <td class="name-holder">Brown 1 Membership Kit</td>
                          <td class="price-holder">P 9,500.00</td>
                          <td class="quantity-holder">
                            <div class="another">
                              <div class="equal small"><button class="control">-</button></div>
                              <div class="equal">
                                <input class="form-control" type="text" name="">
                              </div>
                              <div class="equal small"><button class="control">+</button></div>
                            </div>
                          </td>
                          <td class="total-holder">P 9,500.00</td>
                        </tr>
                        <tr>
                          <td class="remove-holder">
                            <a href="javascript:"><img src="/themes/{{ $shop_theme }}/img/remove.png"></a>
                          </td>
                          <td class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/wishlist-1.jpg">
                          </td>
                          <td class="name-holder">Brown 1 Membership Kit</td>
                          <td class="price-holder">P 9,500.00</td>
                          <td class="quantity-holder">
                            <div class="another">
                              <div class="equal small"><button class="control">-</button></div>
                              <div class="equal">
                                <input class="form-control" type="text" name="">
                              </div>
                              <div class="equal small"><button class="control">+</button></div>
                            </div>
                          </td>
                          <td class="total-holder">P 9,500.00</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="modal-footer row clearfix">
                      <div class="col-md-8">
                        <div class="left-btn-container">
                          <div><i class="fa fa-long-arrow-left" aria-hidden="true">&nbsp;</i>&nbsp;Continue Shopping</div>
                          <button class="btn-checkout">Checkout</button>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="total">Total: P 9,500.00</div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!--  Enter a code -->
  <div class="popup-enter-a-code">
      <div id="enter-a-code-modal" class="modal fade">
          <div class="modal-sm modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-star"></i> SPONSOR</h4>
                  </div>
                  <div class="modal-body">
                      <form method="post" class="submit-verify-sponsor">  
                        <div class="labels">Enter <b>Nickname of Sponsor</b> or <b>Slot Number</b></div>
                        <input required="required" class="input-verify-sponsor text-center" name="verify_sponsor" type="text" placeholder="">
                        <div class="output-container">
                          
                        </div>
                        <div class="btn-container">
                          <button id="btn-verify" class="btn-verify btn-verify-sponsor"><i class="fa fa-check"></i> VERIFY SPONSOR</button>
                        </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Proceed 1 -->
  <div class="popup-proceed1">
      <div id="proceed-modal-1" class="modal fade">
          <div class="modal-sm modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Sponsor</h4>
                  </div>
                  <div class="modal-body">
                      <form>
                          <input type="text" placeholder="Name">
                          <input type="text" placeholder="Enter Code">
                          <input type="text" placeholder="Enter Pin">
                          <div class="btn-container">
                            <button id="btn-proceed-1" class="btn-proceed-1">Proceed</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
  
  <!-- Proceed 2 -->
  <div class="popup-proceed2">
    <div id="proceed-modal-2" class="modal fade">
        <div class="modal-sm modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Sponsor</h4>
                </div>
                <div class="modal-body">
                  <form>
                      <input class="input" type="text" placeholder="Enter Code">
                      <input class="input" type="text" placeholder="Enter Pin">

                      <select name="" id="">
                        <option value="Placement">Placement</option>
                      </select>

                      <div style="font-size: 13px;">Position: </div>

                      <label class="radio-inline" style="padding-left: 78px;">
                        <input type="radio" name="optradio">Left
                      </label>

                      <label class="radio-inline" style="margin-left: 50px;">
                        <input type="radio" name="optradio">Right
                      </label>

                      <div class="btn-container">
                        <button id="btn-proceed-2" class="btn-proceed-2">Proceed</button>
                      </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- Success -->
  <div class="popup-success">
    <div id="success-modal" class="modal">
        <div class="modal-md modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Verification Sucess</h4>
                </div>
                <div class="modal-body">
                    
                    <div><img src="/themes/{{ $shop_theme }}/img/brown-done-img.png"></div>
                    <div class="text-header">Done!</div>
                    <div class="text-caption">You are now officially enrolled to<br>Brown&Proud movement</div>

                    <div class="btn-container">
                      <button id="btn-ok" class="btn-ok">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- Failed -->
  <div class="popup-failed">
  <div id="failed-modal" class="modal">
      <div class="modal-sm modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><img width="37" height="36" src="/themes/{{ $shop_theme }}/img/brown-failed-img.png"> Verification Failed</h4>
              </div>
              <div class="modal-body">
          
                  <div class="text-caption">This sponsor does'nt exits!</div>

                  <div class="btn-container">
                    <button id="btn-back" class="btn-back">Back</button>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

</div>

@endsection
@section("member_script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/non_member.js"></script>

<script type="text/javascript">

      // /*Buy a Kit*/
      // $("#btn-buy-a-kit").click(function(){
      //   $("#buy-a-kit-modal").modal('show');
      // });

      // /*Enter a code*/
      // $("#btn-enter-a-code").click(function(){
      //   $("#enter-a-code-modal").modal('show');
      // });

      // /*Proceed 1*/
      // $("#btn-verify").click(function(){
      //   $("#proceed-modal-1").modal('show');
      // });

      // /*Proceed 2*/
      // $("#btn-verify").click(function(){
      //   $("#proceed-modal-2").modal('show');
      // });

      // /*Success*/
      // $("#btn-proceed-2").click(function(){
      //   $("#success-modal").modal('show');
      // });

      // /*Failed*/
      // $("#btn-proceed-2").click(function(){
      //   $("#failed-modal").modal('show');
      // });

</script>

@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/nonmember_dashboard.css">
@endsection