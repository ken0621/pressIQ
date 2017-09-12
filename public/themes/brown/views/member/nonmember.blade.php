@extends("member.member_layout")
@section("member_content")
<div class="dashboard">
	
	<div class="col-md-8">
			<div class="img-container">
				<img src="/themes/{{ $shop_theme }}/img/brown-img1.png">
			</div>
	</div>
	<div class="col-md-4">
			<div class="join-container">
				<div class="text-header">Become a Member</div>

				<div class="btn-container">
            <button class="join-us-today">Join us Today</button>
            <button class="enter-a-code">Enter a Code</button>
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
</script>
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/nonmember_dashboard.css">
@endsection