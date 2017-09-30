var global = new global();

function global()
{
	init();

	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		});
	}

	function document_ready()
	{
		action_chart_js();
	}

	function action_chart_js()
	{
		if (document.getElementById("income_summary") != null) 
		{
			$wallet = $(".chart-income").attr("wallet") == 0 ? 1 : $(".chart-income").attr("wallet");
			$payout = $(".chart-income").attr("payout") == 0 ? 1 : $(".chart-income").attr("payout");

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
	}
}