@extends("member.member_layout")
@section("member_content")

<input type="hidden" name="_mode" class="_mode" value="{{ $mode }}">
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}">
@if(!$mlm_member)
	<div class="dashboard">
	    <div class="dashboard-top">
	        <div class="row clearfix">
	            <div class="col-md-12">
	            	<div class="title">NON-MEMBER | <span>DASHBOARD</span> </div>
	                <div class="join-container" style="background-image: url('/themes/{{ $shop_theme }}/img/nonmember-bg.png');">
	                    <div class="btn btn-text">
	                        <div class="text-header1">Become A Member Now!</div>
	                        <div class="text-header2">Opportunity awaits you. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<br>Aenean commodo ligula eget dolor.</div>
	                    </div>
	                    <div class="btn-container">
	                        <!-- <a href="#" id="btn-buy-a-kit"><button class="btn-buy-a-kit">BUY A KIT</button></a> -->
	                        <!-- <img src="/themes/{{ $shop_theme }}/img/or-1.png"><br> -->
	                        <!-- <span class="or">OR</span> -->
	                        <a href="#" id="btn-enter-a-code"><button class="btn-enter-a-code">ENTER A CODE</button></a>
	                        @if(isset($company_head_id))
	                        	</br>
	                        	<span style="color:white">or</span>
	                        	</br>
	                        	<a href="#" id="btn-enter-a-code"><button class="btn-enter-a-code no_sponsor_code" company_head_id="{{$company_head_id->slot_no}}">NO SPONSOR?</button></a>
	                    	@endif
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@else
	<div class="dashboard">
		<div class="row clearfix">
			<div class="col-md-6">
				<div class="title"><i class="align-icon brown-icon-bar-chart"></i> Wallet Summary</div>
				<div class="sub-container">
					<div class="table-holder">
						<div class="chart-legend">
							<div class="holder">
								<div class="color" style="background-color: #76b6ec"></div>
								<div class="name"><span>Current Wallet</span> {{ $wallet->display_current_wallet }}</div>
							</div>
							<div class="holder">
								<div class="color" style="background-color: #8E5EA2"></div>
								<div class="name"><span>Total Pay-out</span> {{ $wallet->display_total_payout }}</div>
							</div>
							<!-- <div class="holder">
								<div class="color"></div>
								<div class="name"><span>Current Slot(s)</span> {{ $customer_summary["display_slot_count"] }}</div>
							</div> -->
							<div class="holder">
								<div class="color"></div>
								<div class="name"><span>Total Reward</span> {{ $wallet->display_total_earnings }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="title"><i class="fa fa-table"></i> Reward Summary</div>
				<div class="sub-container">
					<div class="chart-legend">
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Wholesale Commission</span><span class="value">{{ $wallet->display_complan_direct }}</span></div>
						</div>
					</div>
					<div class="chart-legend">
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Personal Rebates</span><span class="value">{{ $wallet->display_complan_rank_repurchase_cashback }}</span></div>
						</div>
					</div>
					<div class="chart-legend">
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Performace Commission</span><span class="value">{{ $wallet->display_complan_stairstep }}</span></div>
						</div>
					</div>
				</div>

				<div class="title"><i class="align-icon brown-icon-gift"></i> Reward Points</div>
				<div class="sub-container">
					<div class="chart-legend" style="min-height: 117px; max-height: auto;">
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Rank PV</span><span class="value">{{ $points->display_rank_pv }}</span></div>
						</div>
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Rank Group PV</span><span class="value">{{ $points->display_rank_gpv }}</span></div>
						</div>
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Stair Step PV</span><span class="value">{{ $points->display_stairstep_pv }}</span></div>
						</div>
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Stair Step Group PV</span><span class="value">{{ $points->display_stairstep_gpv }}</span></div>
						</div>
					</div>
				</div>
				<div class="title">Enter Product Code</div>
				<div class="sub-container">
					<div class="chart-legend text-center">
						<button class="btn btn-default" onClick="action_load_link_to_modal('/members/slot-useproductcode', 'md')">Use Product Code</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row clearfix">
			<div class="col-md-6">
				<div class="title"><i class="align-icon brown-icon-globe"></i> Newest Direct Referrals</div>
				<div class="sub-container border-holder">
					<div class="clearfix wow hidden">
						<div class="badge right">6 New Members</div>
					</div>
					@if(count($_direct) > 0)
						@foreach($_direct as $direct)
						<div class="holder">
							<div class="color">
								<img src="{{ $direct->profile_image }}">
							</div>	
							<div class="text">
								<div class="pull-left">
									<div class="name">{{ $direct->first_name }} {{ $direct->last_name }}</div>
									<div class="email">{{ $direct->slot_no }}</div>
									<div class="date">{{ $direct->time_ago }}</div>
								</div>
							</div>
							<div class="action pull-right">
								@if($direct->distributed == 1)
									<button onclick="action_load_link_to_modal('/members/slot-info?slot_no={{ Crypt::encrypt($direct->slot_id) }}&key={{ md5($direct->slot_id . $direct->slot_no) }}')" class="btn btn-default"><i class="fa fa-star"></i> VIEW INFO</button>
								@else
									<button class="btn btn-danger place_slot_btn" place_slot_id="{{$direct->slot_id}}"><i class="fa fa-warning"></i> PLACE THIS SLOT</button>
								@endif
							</div>
						</div>
						@endforeach
					@else

						<div class="text-center" style="padding: 20px">You don't have any direct referral yet.</div>
					@endif
				</div>
			</div>
			<div class="col-md-6">
				<div class="match-height">
					<div class="title"><i class="align-icon brown-icon-money"></i> Recent Rewards <a href="javascript:" class="title-button pull-right" onclick="location.href='/members/report'">View All Rewards</a></div>
					<div class="sub-container">
						<div class="activities">
							@if(count($_recent_rewards) > 0)
								@foreach($_recent_rewards as $recent_reward)
								<div class="holder">
									<div class="circle-line">
										<div class="circle"><img src="/themes/{{ $shop_theme }}/img/circle.png"></div>
										<div class="line"><img src="/themes/{{ $shop_theme }}/img/line.jpg"></div>
									</div>
									<div class="message">{!! $recent_reward->log !!}</div>
									<div class="row clearfix">
										<div class="col-sm-6">
											<div class="date">{{ $recent_reward->time_ago }}</div>
										</div>
										<div class="col-sm-6">
											<div class="wallet"> EARNED BY {{ $recent_reward->slot_no }}</div>
										</div>
									</div>
								</div>
								@endforeach
							@else
								<div class="text-center" style="padding: 20px">You don't have any reward yet.</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>


	    <!-- Success -->
	    <div class="popup-success">
	        <div id="success-modal" class="modal success-modal fade">
	            <div class="modal-md modal-dialog">
	                <div class="modal-content">
	                    <div class="modal-body">
	                        <div><img src="/themes/{{ $shop_theme }}/img/brown-done-img.png"></div>
	                        <div class="text-header">Done!</div>
	                        <div class="text-caption">You are now officially enrolled to<br><b>Brown & Proud</b> movement</div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endif

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
                        <div class="labels"><b>Enter a Slot Number</b></div>
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
            <div class="modal-content load-final-verification">
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
                    <h4 class="modal-title"><i class="fa fa-shield"></i> CODE VERIFICATION</h4>
                </div>
                <div class="modal-body">
                    <div class="message message-return-code-verify"></div>
                    <form class="code-verification-form">
                        <div>
                            <div class="labeld">Pin Code</div>
                            <input class="input input-pin text-center" name="pin" type="text">
                        </div>
                        <div>
                            <div class="labeld">Activation</div>
                            <input class="input input-activation text-center" name="activation" type="text">
                        </div>
                        <div class="btn-container">
                            <button id="btn-proceed-2" class="btn-proceed-2"><i class="fa fa-angle-double-right"></i> Proceed</button>
                        </div>
                    </form>
                </div>
              </div>
          </div>
      </div>
  </div>
<!-- MANUAL PLACING OF SLOT -->
<div class="popup-verify-placement">
    <div id="slot-placement-modal" class="modal fade">
        <div class="modal-sm modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-shield"></i> MANUAL PLACEMENT</h4>
                </div>
                <div class="modal-body">
                    <div class="message message-return-slot-placement-verify"></div>
                    <form class="slot-placement-form">
                        <div>
                            <div class="labeld">Slot Placement</div>
                            <input class="input input-slot-placement text-center" name="slot_placement" type="text">
                            <input class="chosen_slot_id" name="chosen_slot_id" type="hidden">
                        </div>
                        <div>
                            <div class="labeld">Slot Position</div>
                            <select class="input input-slot-position text-center" name="slot_position" type="text" style="text-align-last:center;">
                            	<option value="left">LEFT</option>
                            	<option value="right">RIGHT</option>
                            </select>
                        </div>
                        <div class="btn-container">
                            <button id="check_placement" class="btn-verify-placement">VERIFY</button>
                        </div>
                    </form>
                </div>
              </div>
          </div>
      </div>
  </div>
@endsection

@section("member_script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/non_member.js"></script>
<script type="text/javascript" src='/assets/chartjs/Chart.bundle.min.js'></script>
@endsection

@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_dashboard.css">
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/nonmember_dashboard.css">
@endsection