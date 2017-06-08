var dashboard = new dashboard();

function dashboard()
{
  init();

  function init()
  {
    document_ready();
  }

  function document_ready()
  {
    action_doughnut_chart();
    action_linegraph_chart();
    action_bar_stackedP_chart();
    /** So On **/
  }

  function action_doughnut_chart()
  {
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {

        type: 'doughnut',
        data: {
          labels: ["Africa", "Asia"],
          datasets: [{
            backgroundColor: [
              "#01837E",
              "#00A6A4",
            ],
            data: [100, 20,]
          }]
        }
      });
  }
  function action_linegraph_chart()
  {
    var ctx = document.getElementById('ChartGraph').getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'line',
      data: {
      labels: ['Apr 1', '', '', '', '', '', 'Apr 30'],
      datasets: [{
        data: [12, 19, 3, 17, 6, 3, 7],
        backgroundColor: "rgba(255,153,0,0.6)"
      },
      ]
    }
  });
  }

  function action_bar_stackedP_chart()
  {
    var barChartData = {
            labels: [""],
            datasets: [{
                label: 'Open',
                backgroundColor: "rgba(220,220,220,0.5)",
                data: [open_invoice]
            }, {
                label: 'Overdue',
                backgroundColor: "rgba(151,187,205,0.5)",
                data: [overdue_invoice]
            }, {
                label: 'Paid',
                backgroundColor: "rgba(160,120,205,0.5)",
                data: [paid_invoice]
            }]

        };

    var ctx = document.getElementById("income_bar_chart").getContext("2d");
    ctx.canvas.height = 500;
    window.myBar = new Chart(ctx, {
        responsive: true,
        type: 'bar',
        data: barChartData,
        options: {
            tooltips: {
                mode: 'label'
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });
  }
}
















