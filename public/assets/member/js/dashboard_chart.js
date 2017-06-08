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
          labels: expense_name,
          datasets: [{
            backgroundColor: expense_color,
            data: expense_value
          }]
        }
      });
  }
  // "#254d6f",
  // "#3682c3",
  // "#0963b1",
  // "#0963b1",
  // "#76a9d6",

  function action_linegraph_chart()
  {
    var ctx = document.getElementById('ChartGraph').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
        data: {
        labels: ['Apr 1', '', '', '', '', '', 'Apr 30'],
        datasets: [{
          data: [12, 19, 3, 17, 6, 3, 7],
          backgroundColor: "#79b941"
        },
        ]
      }
    });
  }

  function action_bar_stackedP_chart()
  {
    var barChartData = {
            labels: ["Invoice"],
            datasets: [{
                label: 'Open',
                backgroundColor: "#fbb850",
                data: [open_invoice]
            }, {
                label: 'Overdue',
                backgroundColor: "#f58c1f",
                data: [overdue_invoice]
            }, {
                label: 'Paid',
                backgroundColor: "#f9a32c",
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

  var randomColorFactor = function() {
        return Math.round(Math.random() * 255);
  };
  var randomColor = function(opacity) {
      return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
  };
}
















