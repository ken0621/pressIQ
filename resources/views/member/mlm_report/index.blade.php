@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-folder-open-o"></i>
            <h1>
                <span class="page-title">Multilevel Marketing Report</span>
                <small>
                    Reports from multilevel marketing
                </small>
            </h1>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <!-- Boxes de Acoes -->
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">                           
                <div class="icon">
                    <div class="image"><i class="fa fa-sitemap"></i></div>
                    <div class="info">
                        <h3 class="title">SLOTS</h3>
                        <p>
                           
                        </p>
                        <div class="more">
                           ACTIVE SLOTS: {{$count_all_slot_active}}
                        </div>
                        <div class="more">
                           INACTIVE SLOTS: {{$count_all_slot_inactive}}
                        </div>
                    </div>
                </div>
                <div class="space"></div>
            </div> 
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">                           
                <div class="icon">
                    <div class="image"><i class="fa fa-flag-checkered"></i></div>
                    <div class="info">
                        <h3 class="title">SLOTS PER MEMBERSHIP</h3>
                        <p>
                           
                        </p>
                        <?php $total_membership_price = 0; ?>
                        @foreach($membership as $key => $value)
                        <div class="more">
                           {{$value->membership_name}}: {{$membership_count[$key]}}
                           <?php $total_membership_price += $membership_price[$key];?>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="space"></div>
            </div> 
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="box">                           
                <div class="icon">
                    <div class="image"><i class="fa fa-user"></i></div>
                    <div class="info">
                        <h3 class="title">ACOUNTS</h3>
                        <p>
                           
                        </p>
                        
                        <div class="more">
                           Registered Accounts: {{$customer_account}}
                        </div>
                        <div class="more">
                            <br>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
            </div> 
        </div>

        

        

        
    </div>
</div>
<div class="col-md-12"><hr></div>
<div class="col-md-12">
    <div class="col-md-6">
        <canvas  id="myChart" width="100%" height="50%"></canvas>
    </div>
    <div class="col-md-6">
        <div class="box">                           
            <div class="icon">
                <div class="image"><i class="fa fa-money"></i></div>
                <div class="info">
                    <h3 class="title">Encashment</h3>
                    <p>
                       
                    </p>
                   <?php $total_wallet = 0; ?>
                   <div class="more">
                       Pending : {{$not_encashed}}
                   </div>
                   <div class="more">
                       Requested : {{$not_encashed_requested * (-1)}}
                   </div>
                   <div class="more">
                       Released : {{$not_encashed_encashed * (-1)}}
                   </div>
                   <div class="more">
                       Total : {{$total_wallet += ($not_encashed_encashed * (-1))+ ($not_encashed_requested * (-1)) + $not_encashed }}
                   </div>
                </div>
            </div>
            <div class="space"></div>
        </div> 
    </div>
</div>
<div class="col-md-12"><hr></div>
<div class="col-md-12">
    <div class="col-md-6">
        <canvas  id="myChart_encashment" width="100%" height="50%"></canvas>
    </div>
    <div class="col-md-6">
        <div class="box">                           
            <div class="icon">
                <div class="image"><i class="fa fa-money"></i></div>
                <div class="info">
                    <h3 class="title">INCOME PER COMPLAN</h3>
                    <p>
                       
                    </p>
                    <?php $total_income_per_complan = 0; ?>
                    @foreach($chart_per_complan_raw['plan'] as $key => $value)
                    <div class="more">
                       {{$value}} : {{$chart_per_complan_raw['series'][$key]}}
                    </div>
                    <?php $total_income_per_complan += $chart_per_complan_raw['series'][$key]; ?>
                    @endforeach
                    <div class="more">
                        Total : {{$total_income_per_complan}}
                    </div>
                </div>
            </div>
            <div class="space"></div>
        </div> 
    </div>
</div>
<div class="col-md-12">
    <div class="col-md-6">
        <canvas  id="myChart_in_out" width="100%" height="50%"></canvas>
    </div>
    <div class="col-md-6">
        <div class="box">                           
            <div class="icon">
                <div class="image"><i class="fa fa-money"></i></div>
                <div class="info">
                    <h3 class="title">PAYIN/PAYOUT</h3>
                    <p>
                       
                    </p>
                    
                    <div class="more">
                       PAYIN : {{$total_membership_price}}
                    </div>
                    <div class="more">
                       EXPECTED PAYOUT: {{$total_income_per_complan}}
                    </div>
                    <div class="more">
                        COMPANY EARNINGS : {{$total_membership_price - $total_income_per_complan }} ({{  ((($total_income_per_complan/$total_membership_price) - 1) * (-1)) *100}}%)
                    </div>
                </div>
            </div>
            <div class="space"></div>
        </div> 
    </div>
</div>
@endsection

@section('script')

<script>
var ctx = document.getElementById("myChart");
var ctx2 = document.getElementById("myChart_encashment");
var ctx3 = document.getElementById("myChart_in_out");
var datass = {!! $chart_per_complan !!};
var datass_encashment = {!! $encashment_json !!};
var backgrounds = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ];
var border =  [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ];    
var options =    {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    };                
// console.log(datass);
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: datass_encashment.labels,
        datasets: [{
            label: 'WALLET ENCASHMENT',
            data: datass_encashment.data,
            backgroundColor: backgrounds,
            borderColor: border,
            borderWidth: 1
        }]
    },
    options: options
});


var myChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: datass.labels,
        datasets: [{
            label: 'INCOME PER COMPLAN',
            data: datass.data,
            backgroundColor: backgrounds,
            borderColor: border,
            borderWidth: 1
        }]
    },
    options: options
});

var myChart = new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: ["PAYIN", "EXPECTED PAYOUT"],
        datasets: [{
            label: 'PAYIN/PAYOUT',
            data: [{{$total_membership_price}}, {{$total_income_per_complan}}],
            backgroundColor: backgrounds,
            borderColor: border,
            borderWidth: 1
        }]
    },
    options: options
});


</script>

@endsection
