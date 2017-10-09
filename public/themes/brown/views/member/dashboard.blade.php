@extends("member.member_layout")
@section("member_content")

<input type="hidden" name="_mode" class="_mode" value="{{ $mode }}">
<input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}">
<input type="hidden" name="code" class="check_unused_code" value="{{ $check_unused_code or 0 }}">
<input type="hidden" name="not_placed_yet" class="not_placed_yet" value="{{ $not_placed_yet or 0 }}" link="/members/enter-placement?slot_no={{ Crypt::encrypt($not_placed_slot->slot_id) }}&key={{ md5($not_placed_slot->slot_id . $not_placed_slot->slot_no) }}">
@if(!$mlm_member)
	<div class="dashboard" style="overflow: hidden;">
    	@if(isset($check_unused_code))
			<!--  CONGRATULATION -->
			<div class="popup-notification">
			    <div id="popup-notification-modal">
		            <div class="modal-content">
		                <!--<div class="modal-header">-->
		                <!--    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
		                <!--    <h4 class="modal-title"><i class="fa fa-star"></i> CONGRATULATION</h4>-->
		                <!--</div>-->
		                <div class="modal-body">
		                	<div class="congrats-holder">
			                	<div class="title">CONGRATULATIONS!</div>
			                    <div class="img">
			                    	<img src="/themes/{{ $shop_theme }}/assets/mobile/img/trophy.png">
			                    </div>
			                    <div class="desc">You are one step away from your membership!</div>
			                    <div class="btn-container">
			                        <button id="btn-notification" class="btn-verify-notification btn-congratulation btn-notification" type="button">Continue</button>
			                    </div>
		                	</div>
		                </div>
		            </div>
		        </div>
			</div>
    	@else
		    <!-- TOP DASHBOARD-->
		    <div class="dashboard-top">
		        <div class="row clearfix">
			        <div class="animated fadeInLeft col-md-8">
			        	<video controls="">
							<source src="/themes/{{ $shop_theme }}/img/intro2.mp4" type="video/mp4">
						</video>
			        </div>
		            <div class="animated fadeInRight col-md-4">
		                <div class="join-container">
		                    <div class="btn btn-text">
		                        <div class="text-header1">Join the Movement!</div>
		                        <div class="text-header2">Enroll now and become one of us!</div>
		                    </div>
		                    <div class="btn-container">
		                        <button class="product-add-cart btn-buy-a-kit" item-id="{{$item_kit_id or '54'}}" quantity="1">Enroll Now</button><br>
		                        <img src="/themes/{{ $shop_theme }}/img/or-1.png"><br>
		                        <a href="#" id="btn-enter-a-code"><button class="btn-enter-a-code">Enter a Code</button></a>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		    <!-- BOTTOM DASHBOARD -->
			<div class="dash-bot row clearfix">
				<div class="wow zoomIn col-md-3">
					<img src="/themes/{{ $shop_theme }}/img/nonmember-ad.jpg" style="width: 100%;">
				</div>
				<div class="col-md-9">
					<h1 class="wow fadeInDown">The Brown Phone</h1>
					<p class="wow fadeInRight">The Brown phone is your portal to a new world full of creativity and opportunities, bringing you closer to artists and entrepreneurs, while keeping you updated on the latest news, hottest trends, and innovative products and services, making your life better and more inspiring.</p>
					<h2 class="wow fadeInDown" >With Premium Content and Rewards App</h2>
					<p class="wow fadeInRight"><i class="fa fa-circle" aria-hidden="true"></i>With Brown App and Portal</p>
					<p class="wow fadeInRight"><i class="fa fa-circle" aria-hidden="true"></i>Agila Rewards Ready</p>
				</div>
			</div>
		@endif
	</div>
@else
	<div class="dashboard" style="overflow: hidden;">
		<!-- <div class="row clearfix">
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
							<div class="chart-holder">
								<canvas id="income_summary" class="chart-income" wallet="{{ $wallet->current_wallet }}"  payout="{{ $wallet->total_payout }}" style="max-width: 150px;" width="400" height="400"></canvas>
							</div>
							<div class="holder">
								<div class="color"></div>
								<div class="name"><span>Current Slot(s)</span> {{ $customer_summary["display_slot_count"] }}</div>
							</div>
							<div class="holder">
								<div class="color"></div>
								<div class="name"><span>Total Reward</span> {{ $wallet->display_total_earnings }}</div>
							</div>
						</div>
		
						<table class="table hidden">
							<thead>
								<tr>
									<th width="33.3333333333%">Level</th>
									<th width="33.3333333333%">Count</th>
									<th width="33.3333333333%">Percentage</th>
								</tr>
							</thead>
							<tbody class="table-body">
								<tr style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 100%);">
									<td>1</td>
									<td>2/2</td>
									<td>100%</td>	
								</tr>
								<tr style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 100%);">
									<td>2</td>
									<td>4/4</td>
									<td>100%</td>	
								</tr>
								<tr style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 100%);">
									<td>4</td>
									<td>8/8</td>
									<td>100%</td>	
								</tr>
								<tr style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 100%);">
									<td>5</td>
									<td>16/16</td>
									<td>100%</td>	
								</tr>
								<tr style="background: linear-gradient(to right, rgb(220, 220, 220) 98.875%, rgb(237, 237, 237) 98.875%);">
									<td>6</td>
									<td>31/32</td>
									<td>98.875%</td>	
								</tr>
								<tr style="background: linear-gradient(to right, rgb(220, 220, 220) 40.625%, rgb(237, 237, 237) 40.625%);">
									<td>7</td>
									<td>26/64</td>
									<td>40.625%</td>	
								</tr>
								<tr style="background: linear-gradient(to right, rgb(220, 220, 220) 28.90625%, rgb(237, 237, 237) 28.90625%);">
									<td>8</td>
									<td>37/128</td>
									<td>28.90625%</td>	
								</tr>
								<tr style="background: linear-gradient(to right, rgb(220, 220, 220) 20.3125%, rgb(237, 237, 237) 20.3125%);">
									<td>9</td>
									<td>52/256</td>
									<td>20.3125%</td>	
								</tr>
								<tr style="background: linear-gradient(to right, rgb(220, 220, 220) 13.4765625%, rgb(237, 237, 237) 13.4765625%);">
									<td>10</td>
									<td>69/512</td>
									<td>13.4765625%</td>	
								</tr>
								<tr style="background: linear-gradient(to right, rgb(220, 220, 220) 4.1015625%, rgb(237, 237, 237) 4.1015625%);">
									<td>11</td>
									<td>42/1024</td>
									<td>4.1015625%</td>	
								</tr>
								<tr style="background: linear-gradient(to right, rgb(220, 220, 220) 1.953125%, rgb(237, 237, 237) 1.953125%);">
									<td>12</td>
									<td>40/2048</td>
									<td>1.953125%</td>	
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		
			<div class="col-md-6">
				<div class="title"><i class="fa fa-table"></i> Reward Summary</div>
				<div class="sub-container">
					<div class="chart-legend">
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Pairing Reward</span> {{ $wallet->display_complan_triangle }}</div>
						</div>
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Direct Referral Bonus</span> {{ $wallet->display_complan_direct }}</div>
						</div>
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Builder Reward</span> {{ $wallet->display_complan_builder }}</div>
						</div>
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Leader Reward</span> {{ $wallet->display_complan_leader }}</div>
						</div>
					</div>
		
				</div>
		
				<div class="title"><i class="align-icon brown-icon-gift"></i> Reward Points</div>
				<div class="sub-container">
					<div class="chart-legend" style="min-height: 117px; max-height: auto;">
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Builder Point(s)</span> {{ $points->display_brown_builder_points }}</div>
						</div>
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Leader Point(s)</span> {{ $points->display_brown_leader_points }}</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<!-- WALLET SUMMARY -->
		<div class="row clearfix">
			<div class="col-md-3">
				<div class="animated fadeInRight per-summary-container box1 row clearfix">
					<div class="col-md-4">
						<div class="icon-container">
							<img src="/themes/{{ $shop_theme }}/img/wallet-icon.png">
						</div>
					</div>
					<div class="col-md-8">
						<div class="detail-container">
							<h2>{{ $wallet->display_current_wallet }}</h2>
							<h3>Current Wallet</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="animated fadeInRight per-summary-container box2 row clearfix">
					<div class="col-md-4">
						<div class="icon-container">
							<img src="/themes/{{ $shop_theme }}/img/total-payout.png">
						</div>
					</div>
					<div class="col-md-8">
						<div class="detail-container">
							<h2>{{ $wallet->display_total_payout }}</h2>
							<h3>Total Pay-out</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="animated fadeInRight per-summary-container box3 row clearfix">
					<div class="col-md-4">
						<div class="icon-container">
							<img src="/themes/{{ $shop_theme }}/img/current-slots.png">
						</div>
					</div>
					<div class="col-md-8">
						<div class="detail-container">
							<h2>{{ $customer_summary["display_slot_count"] }}</h2>
							<h3>Current Slot(s)</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="animated fadeInRight per-summary-container box4 row clearfix">
					<div class="col-md-4">
						<div class="icon-container">
							<img src="/themes/{{ $shop_theme }}/img/total-rewards.png">
						</div>
					</div>
					<div class="col-md-8">
						<div class="detail-container">
							<!-- <h1>PHP</h1> -->
							<h2>{{ $wallet->display_total_earnings }}</h2>
							<h3>Total Reward</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- ACADEMY -->
		<!-- <div class="academy-container">
			<div class="row-no-padding clearfix">
				<div class="col-md-6 left-section">
					<form action="">
						<img src="/themes/{{ $shop_theme }}/img/left.jpg" alt="">
						<div class="row row-no-padding">
							<div class="col-md-4">
								<input style="border-radius: 0px; border-right: 0; box-shadow: none !important;" class="form-control input-sm" type="text" placeholder="Family Name">
							</div>
							<div class="col-md-4">
								<input style="border-radius: 0px; border-left: 0; box-shadow: none !important;" class="form-control input-sm" type="text" placeholder="First Name">
							</div>
							<div class="col-md-4" style="padding-left: 3px !important;">
								<input style="border-radius: 0px; box-shadow: none !important;" class="form-control input-sm" type="text" placeholder="Middle Name">
							</div>
						</div>
						<textarea name="" class="address form-control input-sm" id="" placeholder="Address"></textarea>
					</form>
				</div>	
				<div class="col-md-6 right-section">
					<img src="/themes/{{ $shop_theme }}/img/right.jpg" alt="">
				</div>
			</div>
		</div> -->

		<div class="row clearfix">
			<div class="animated fadeInUp col-md-6">
				<div class="title"><i class="fa fa-table"></i> Reward Summary</div>
				<div class="sub-container" style="padding-bottom: 46px !important;">
					<div class="chart-legend">
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Pairing Reward</span><span class="value">{{ $wallet->display_complan_triangle }}</span></div>
						</div>
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Direct Referral Bonus</span><span class="value">{{ $wallet->display_complan_direct }}</span></div>
						</div>
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Builder Reward</span><span class="value">{{ $wallet->display_complan_builder }}</span></div>
						</div>
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Leader Reward</span><span class="value">{{ $wallet->display_complan_leader }}</span></div>
						</div>
					</div>	
				</div>
			</div>
			<div class="animated fadeInUp col-md-6">
				<div class="title"><i class="align-icon brown-icon-gift"></i> Reward Points</div>
				<div class="sub-container">
					<div class="chart-legend" style="min-height: 117px; max-height: auto;">
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Builder Point(s)</span><span class="value">{{ $points->display_brown_builder_points }}</span></div>
						</div>
						<div class="holder">
							<div class="color"></div>
							<div class="name"><span>Leader Point(s)</span><span class="value">{{ $points->display_brown_leader_points }}</span></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row clearfix">
			<div class="animated fadeInUp col-md-12">
				<div class="unilevel-holder">
					<div class="title"><i class="align-icon brown-icon-star"></i> My Slot(s) </div>
					<div class="sub-container">
						@foreach($_slot as $slot)
						<div class="holder">
							<div class="row clearfix">
								<div class="col-sm-4 text-center">
									<div class="label2">{{ $slot->slot_no }}</div>
									<div class="label3"> <a href="javascript:" onclick="action_load_link_to_modal('/members/lead?slot_no={{ $slot->slot_no }}')"> VIEW LEAD LINK</a></b></div>
									<div class="label3">{{ $slot->display_total_earnings }}</div>
									{{-- $slot->current_direct }} / {{ $slot->brown_next_rank_current --}}
								</div>
								<div class="col-sm-8 text-center" style="margin-bottom: 5px;">ROAD TO <b>{{ $slot->brown_next_rank }}</div>
							
								<div class="col-sm-4">
									@if($slot->brown_next_rank != "NO NEXT RANK")
										@if($slot->current_direct >= $slot->required_direct)
											<div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 100%);">DIRECT <b>QUALIFIED</b></div>
										@else
											<div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) {{ $slot->brown_direct_rank_percentage }}%, rgb(237, 237, 237) {{ $slot->brown_direct_rank_percentage }}%);">DIRECT ({{ $slot->current_direct }}/{{ $slot->required_direct }})</div>
										@endif
									@else
									<div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 40%);">NO MORE <b> NEXT RANK</b></div>
									@endif
								</div>
								<div class="col-sm-4">
									@if($slot->brown_next_rank != "NO NEXT RANK")
										@if($slot->brown_next_rank_current >= $slot->brown_next_rank_requirements)
											<div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 100%);">GROUP <b>QUALIFIED</b></div>
										@else
											<div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) {{ $slot->brown_rank_rank_percentage }}%, rgb(237, 237, 237) {{ $slot->brown_rank_rank_percentage }}%);">GROUP ({{ $slot->brown_next_rank_current }}/{{ $slot->brown_next_rank_requirements }})</div>
										@endif
									@else
									<div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 40%);">NO MORE <b> NEXT RANK</b></div>
									@endif
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="row clearfix">
			<div class="animated fadeInUp col-md-6">
				<div class="title"><i class="align-icon brown-icon-globe"></i> Newest Enrollee(s) Sponsored</div>
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
									<button onclick="action_load_link_to_modal('/members/enter-placement?slot_no={{ Crypt::encrypt($direct->slot_id) }}&key={{ md5($direct->slot_id . $direct->slot_no) }}')" class="btn btn-danger"><i class="fa fa-warning"></i> PLACE THIS SLOT</button>
								@endif
							</div>
						</div>
						@endforeach
					@else

						<div class="text-center" style="padding: 20px">You don't have any direct referral yet.</div>
					@endif
				</div>
			</div>
			<div class="animated fadeInUp col-md-6">
				<div class="match-height">
					<div class="title"><i class="align-icon brown-icon-money"></i> Recent Rewards <a href="javascript:" class="title-button pull-right">View All Rewards</a></div>
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

		<!-- Popup Academy -->
	    <div class="popup-academy">
	        <div id="academy-modal" class="modal academy-modal fade">
	            <div class="modal-lg modal-dialog">
	                <div class="modal-content">
	                    
	                    <div class="modal-header">
	                    	<div class="container">
								<div class="row clearfix">
							        <div class="col-md-4">
							        	<div class="logo-container">
							        		Logo Here
							        	</div>
							        </div>

							        <div class="cold-md-8">
							        	<div class="header-container">
							        		<h2>BROWN&PROUD ACADEMY</h2>
							        		<h3>MATERCLASS IN CREATIVE ENTREPRENEURSHIP</h3>
							        	</div>
							        </div>
								</div>
							</div>
					    </div>

						<div class="modal-body">
							
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

@endsection

@section("member_script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/non_member.js?version=2.1"></script>
<script type="text/javascript" src='/assets/chartjs/Chart.bundle.min.js'></script>
<script>

$(document).ready(function()
{
	$wallet = $(".chart-income").attr("wallet");
	$payout = $(".chart-income").attr("payout");
	
	var exist = document.getElementById("income_summary");
	
	if (exist != null) 
	{
		var ctx = document.getElementById("income_summary").getContext('2d');
		
		var myDoughnutChart = new Chart(ctx,
		{
		    type: 'doughnut',
		    data: {
		        labels: ["Red", "Blue"],
		        datasets: [{
		            label: '# of Votes',
		            data: [$payout, $wallet],
		            backgroundColor: [
		                'rgba(142, 94, 162, 1)',
		                'rgba(62, 149, 205, 1)'
		            ],
		            borderColor: [
		                'rgba(142, 94, 162, 1)',
		                'rgba(62, 149, 205, 1)'
		            ],
		            borderWidth: 1
		        }]
		    },
		    options: 
		    {
		      legend: 
		      {
		        responsive: true,
		        display: false,
		      },
		      tooltips: 
		      {
		        callbacks: 
		        {
		          label: function(tooltipItems, data) 
		          {
		            var sum = data.datasets[0].data.reduce(add, 0);
		            function add(a, b) {
		              return a + b;
		            }
	
		            return data.datasets[0].data[tooltipItems.index];
		          },
		        }
		      }
		    }
		});
	} 
	

});

</script>
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_dashboard.css">
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/nonmember_dashboard.css">


<style type="text/css">

input:-webkit-autofill
{
    -webkit-box-shadow: 0 0 0 30px white inset;
}

/* PLACEMENT VERIFIER */
.popup-verify-placement {
  background-color: #EEEEEE;
  font-family: "Arimo", sans-serif; }
  .popup-verify-placement .modal-sm {
    width: 100%;
    max-width: 500px; }
  .popup-verify-placement .modal-content {
    background-color: #eee; }
    .popup-verify-placement .modal-content .modal-header {
      background-color: #693d28;
      border-top-left-radius: 3px;
      border-top-right-radius: 3px; }
      .popup-verify-placement .modal-content .modal-header .close {
        color: #FFF; }
      .popup-verify-placement .modal-content .modal-header .modal-title {
        font-weight: 600;
        color: #FFF;
        font-size: 15px; }
    .popup-verify-placement .modal-content .modal-body {
      font-weight: 600;
      margin: 0px 20px 0px 20px; }
      .popup-verify-placement .modal-content .modal-body .message {
        text-align: center;
        margin-bottom: 10px;
        color: red;
        font-size: 14px;
        text-transform: uppercase; }
      .popup-verify-placement .modal-content .modal-body .input {
        width: 100%;
        font-size: 16px;
        border: none;
        border: 1px solid #693d28;
        margin: 5px 0px;
        margin-bottom: 15px;
        padding: 5px;
        border-radius: 2px; }
      .popup-verify-placement .modal-content .modal-body label {
        font-size: 13px;
        text-align: center !important;
        margin: 10px 0px;
        padding: 10px; }
      .popup-verify-placement .modal-content .modal-body .labeld {
        color: #693d28;
        text-align: center;
        text-transform: uppercase; }
      .popup-verify-placement .modal-content .modal-body select {
        width: 100%;
        font-size: 16px;
        border: none;
        border: 1px solid #693d28;
        margin: 5px 0px;
        margin-bottom: 15px;
        padding: 5px;
        border-radius: 2px; }
      .popup-verify-placement .modal-content .modal-body .btn-container {
        text-align: center;
        font-family: "Arimo", sans-serif;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        padding-bottom: 20px; }
        .popup-verify-placement .modal-content .modal-body .btn-container .btn-verify-placement {
          color: #693d28;
          background-color: #fff;
          padding: 10px 40px;
          border: 2px solid #693d28;
          border-radius: 2px;
          opacity: 0.9;
          -webkit-transition: all 0.2s ease-in-out;
          -moz-transition: all 0.2s ease-in-out;
          -o-transition: all 0.2s ease-in-out;
          transition: all 0.2s ease-in-out;
          width: 100%;
          margin-top: 20px;
          text-transform: uppercase; }
        .popup-verify-placement .modal-content .modal-body .btn-container .btn-verify-placement:hover {
          color: #fff;
          background-color: #693d28;
          opacity: 1.0; }
</style>
@endsection