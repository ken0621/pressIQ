@extends("member.member_layout")
@section("member_content")

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
            <div class="text-header1">Become a Member</div>
            <div class="text-header2">Enroll now and become one of us!</div>
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

            <div class="col-md-4">
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

            <div class="col-md-4">
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

            <div class="col-md-4">
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
          <div class="modal-lg modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><img src="/themes/{{ $shop_theme }}/img/cart.png"> My Shopping Cart</h4>
                  </div>
                  <div class="modal-body">
                      <h4>Item has successfully added to your Cart!</h4>

                      <div class="row clearfix">
                        <div class="col-md-6">
                          <div class="img-container">
                            <img width="261" height="264" src="/themes/{{ $shop_theme }}/img/brown-img-mobile.png">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="details">
                              <div class="text-header">Phone Details</div>
                              <div class="specs">
                                MT6737 64-bit Quad-Core Processor<br>
                                4.7" HD IPS Display<br>
                                16GB ROM | 2 GB RAM<br>
                                expandable up to 64gb microSD slot<br>
                                13MP Auto-Focus Main Camera W/ 5MP Front Camera<br>
                                4G LTE<br>
                                Fingerprint Scanner<br>
                                USB OTG<br>
                                IR BLASTER<br>
                                1800mAh Battery
                              </div>
                          </div>
                          

                          <div class="btn-container">
                            <button class="btn-proceed-to-payment">Proceed to payment</button>
                          </div>
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
                      <h4 class="modal-title">Sponsor</h4>
                  </div>
                  <div class="modal-body">
                      <form>
                        <input type="text" placeholder="Enter Your Sponsor">
                        <div class="btn-container">
                          <button id="btn-verify" class="btn-verify">Verify</button>
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
                      <input class="input" type="text" placeholder="Julia Lim (Slot #215678)">
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

<script type="text/javascript">

  /*Popups*/
  $(document).ready(function(){

      /*Buy a Kit*/
      $("#btn-buy-a-kit").click(function(){
        $("#buy-a-kit-modal").modal('show');
      });

      /*Enter a code*/
      $("#btn-enter-a-code").click(function(){
        $("#enter-a-code-modal").modal('show');
      });

      /*Proceed 1*/
      $("#btn-verify").click(function(){
        $("#proceed-modal-1").modal('show');
      });

      /*Proceed 2*/
      $("#btn-verify").click(function(){
        $("#proceed-modal-2").modal('show');
      });

      /*Success*/
      $("#btn-proceed-2").click(function(){
        $("#success-modal").modal('show');
      });

      /*Failed*/
      $("#btn-proceed-2").click(function(){
        $("#failed-modal").modal('show');
      });

  });

</script>

@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/nonmember_dashboard.css">
@endsection