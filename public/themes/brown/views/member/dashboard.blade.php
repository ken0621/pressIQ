@extends("member.member_layout")
@section("member_content")
<input type="hidden" name="_mode" class="_mode" value="{{ $mode }}">

<div class="dashboard">
	<div class="row clearfix">
		<div class="col-md-6">
			<div class="title">Matrix Per Level</div>
			<div class="table-holder">
				<table class="table">
					<thead>
						<tr>
							<th width="33.3333333333%">Level</th>
							<th width="33.3333333333%">Count</th>
							<th width="33.3333333333%">Percentage</th>
						</tr>
					</thead>
					<tbody class="table-body">
						<tr style="background: linear-gradient(to right, rgb(184, 205, 211) 100%, rgb(237, 237, 237) 100%);">
							<td>2</td>
							<td>2/2</td>
							<td>100%</td>	
						</tr>
						<tr style="background: linear-gradient(to right, rgb(184, 205, 211) 100%, rgb(237, 237, 237) 100%);">
							<td>3</td>
							<td>4/4</td>
							<td>100%</td>	
						</tr>
						<tr style="background: linear-gradient(to right, rgb(184, 205, 211) 100%, rgb(237, 237, 237) 100%);">
							<td>4</td>
							<td>8/8</td>
							<td>100%</td>	
						</tr>
						<tr style="background: linear-gradient(to right, rgb(184, 205, 211) 100%, rgb(237, 237, 237) 100%);">
							<td>5</td>
							<td>16/16</td>
							<td>100%</td>	
						</tr>
						<tr style="background: linear-gradient(to right, rgb(184, 205, 211) 98.875%, rgb(237, 237, 237) 98.875%);">
							<td>6</td>
							<td>31/32</td>
							<td>98.875%</td>	
						</tr>
						<tr style="background: linear-gradient(to right, rgb(184, 205, 211) 40.625%, rgb(237, 237, 237) 40.625%);">
							<td>7</td>
							<td>26/64</td>
							<td>40.625%</td>	
						</tr>
						<tr style="background: linear-gradient(to right, rgb(184, 205, 211) 28.90625%, rgb(237, 237, 237) 28.90625%);">
							<td>8</td>
							<td>37/128</td>
							<td>28.90625%</td>	
						</tr>
						<tr style="background: linear-gradient(to right, rgb(184, 205, 211) 20.3125%, rgb(237, 237, 237) 20.3125%);">
							<td>9</td>
							<td>52/256</td>
							<td>20.3125%</td>	
						</tr>
						<tr style="background: linear-gradient(to right, rgb(184, 205, 211) 13.4765625%, rgb(237, 237, 237) 13.4765625%);">
							<td>10</td>
							<td>69/512</td>
							<td>13.4765625%</td>	
						</tr>
						<tr style="background: linear-gradient(to right, rgb(184, 205, 211) 4.1015625%, rgb(237, 237, 237) 4.1015625%);">
							<td>11</td>
							<td>42/1024</td>
							<td>4.1015625%</td>	
						</tr>
						<tr style="background: linear-gradient(to right, rgb(184, 205, 211) 1.953125%, rgb(237, 237, 237) 1.953125%);">
							<td>12</td>
							<td>40/2048</td>
							<td>1.953125%</td>	
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-6">
			<div class="title">Income Summary</div>
			<div class="chart-legend">
				<div class="holder">
					<div class="color" style="background-color: #3e95cd;"></div>
					<div class="name"><span style="color: #3e95cd;">Pairing Reward</span> PHP 68,500.00</div>
				</div>
				<div class="holder">
					<div class="color" style="background-color: #8e5ea2;"></div>
					<div class="name"><span style="color: #8e5ea2;">Direct Referral Bonus</span> PHP 68,500.00</div>
				</div>
			</div>
			<div class="chart-holder">
				<canvas id="income_summary" style="max-width: 150px;" width="400" height="400"></canvas>
			</div>
			<div class="unilevel-holder">
				<div class="title">Unilevel Ranking</div>
				<div class="holder">
					<div class="row clearfix">
						<div class="col-sm-2">
							<div class="label2">Builder</div>
						</div>
						<div class="col-sm-10">
							<div class="progress2" style="background: linear-gradient(to right, rgb(184, 205, 211) 40%, rgb(237, 237, 237) 40%);">4/25 Enrollees</div>
						</div>
					</div>
				</div>
				<div class="holder">
					<div class="row clearfix">
						<div class="col-sm-2">
							<div class="label2">Leader</div>
						</div>
						<div class="col-sm-10">
							<div class="progress2" style="background: linear-gradient(to right, rgb(184, 205, 211) 10%, rgb(237, 237, 237) 10%);">4/50 Enrollees</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-6">
			<div class="border-holder match-height">
				<div class="clearfix wow">
					<div class="title left">New Referral</div>
					<div class="badge right">6 New Members</div>
				</div>
				<div class="holder">
					<div class="color"></div>
					<div class="text">
						<div class="name">JOAQUIN EUGENIO MATTHEW S. CHIPECO</div>
						<div class="date">2017-08-15 08:51:00</div>
					</div>	
				</div>
				<div class="holder">
					<div class="color"></div>
					<div class="text">
						<div class="name">JOAQUIN EUGENIO MATTHEW S. CHIPECO</div>
						<div class="date">2017-08-15 08:51:00</div>
					</div>	
				</div>
				<div class="holder">
					<div class="color"></div>
					<div class="text">
						<div class="name">JOAQUIN EUGENIO MATTHEW S. CHIPECO</div>
						<div class="date">2017-08-15 08:51:00</div>
					</div>	
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="match-height">
				<div class="title">Recent Activities</div>
				<div class="activities">
					<div class="holder">
						<div class="circle-line">
							<div class="circle"><img src="/themes/{{ $shop_theme }}/img/circle.png"></div>
							<div class="line"><img src="/themes/{{ $shop_theme }}/img/line.jpg"></div>
						</div>
						<div class="message">Sorry, Your Slot has already reached the max level for matrix. Slot 454926's pairing reward will not be added.</div>
						<div class="row clearfix">
							<div class="col-sm-6">
								<div class="date">3 Hours Ago</div>
							</div>
							<div class="col-sm-6">
								<div class="wallet">Wallet Amount: 0</div>
							</div>
						</div>
					</div>
					<div class="holder">
						<div class="circle-line">
							<div class="circle"><img src="/themes/{{ $shop_theme }}/img/circle.png"></div>
							<div class="line"><img src="/themes/{{ $shop_theme }}/img/line.jpg"></div>
						</div>
						<div class="message">Sorry, Your Slot has already reached the max level for matrix. Slot 454926's pairing reward will not be added.</div>
						<div class="row clearfix">
							<div class="col-sm-6">
								<div class="date">3 Hours Ago</div>
							</div>
							<div class="col-sm-6">
								<div class="wallet">Wallet Amount: 0</div>
							</div>
						</div>
					</div>
					<div class="holder">
						<div class="circle-line">
							<div class="circle"><img src="/themes/{{ $shop_theme }}/img/circle.png"></div>
							<div class="line"><img src="/themes/{{ $shop_theme }}/img/line.jpg"></div>
						</div>
						<div class="message">Sorry, Your Slot has already reached the max level for matrix. Slot 454926's pairing reward will not be added.</div>
						<div class="row clearfix">
							<div class="col-sm-6">
								<div class="date">3 Hours Ago</div>
							</div>
							<div class="col-sm-6">
								<div class="wallet">Wallet Amount: 0</div>
							</div>
						</div>
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
@endsection
@section("member_script")
<script type="text/javascript" src='/assets/chartjs/Chart.bundle.min.js'></script>
<script>
var ctx = document.getElementById("income_summary").getContext('2d');

// And for a doughnut chart
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["Red", "Blue"],
        datasets: [{
            label: '# of Votes',
            data: [68500.00, 68500.00],
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

            return data.datasets[0].data[tooltipItems.index] + ' %';
          },
          // beforeLabel: function(tooltipItems, data) {
          //   return data.datasets[0].data[tooltipItems.index] + ' hrs';
          // }
        }
      }
    }
});

$(document).ready(function()
{
	//if($("._mode").val() == "success")
	//{
		$("#success-modal").modal("show");
	//}
});

</script>
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/member_dashboard.css">
@endsection