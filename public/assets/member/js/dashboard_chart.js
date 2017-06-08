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
new Chart(document.getElementById("line-chart"), {
  type: 'line',
  data: {
    labels: ["APR1", "", "","" ,"" ,"Apr 30"],
    datasets: [{ 
        data: ["1","2","42","32","23","60s"],
        label: "Produce",
        borderColor: "#3e95cd",
        fill: false
      },  { 
        data: [100,50,20,100,600,300],
        label: "Product",
        borderColor: "#c45850",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: true,

    }
  }
});
  }
}
















