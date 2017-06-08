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
    /** So On **/
  }

  function action_doughnut_chart()
  {
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          datasets: [{
            backgroundColor: [
              "#01837E",
              "#00A6A4",
            ],
            data: [600, 300]
          }],
          labels: [
              'Purchase S',
              'COst Of Good Sold',
          ]
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
}
















