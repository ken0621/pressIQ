@extends("member.member_layout")
@section("member_content")

<div class="dashboard">

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
            <a href="#" class="sample"><button class="join-us-today">Join us Today</button></a>
            <img src="/themes/{{ $shop_theme }}/img/or.png">
            <button class="enter-a-code">Enter a Code</button>
          </div>
        </div>
      </div>
    </div>
  </div>

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

  <div class="popup-enter-a-code">
      <!-- Button HTML (to Trigger Modal) -->

      <!-- Modal HTML -->
      <div id="myModal" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Sponsor</h4>
                  </div>
                  <div class="modal-body">
                      <input type="text">
                  </div>
              </div>
          </div>
      </div>

  </div>

</div>

@endsection
@section("member_script")
<script type="text/javascript" src='/assets/chartjs/Chart.bundle.min.js'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

<script type="text/javascript">
  $(document).ready(function(){
    $(".sample").click(function(){
      $("#myModal").modal('show');
    });
  });
</script>

@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/nonmember_dashboard.css">
@endsection