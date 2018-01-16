@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
            <!-- Dashboard -->
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="title-container">ANALYTICS</div>
                </div>
            </div>
              <table style="width:100%;" >
                    <tr>
                      <th style="text-align: center;">ACTION</th>
                      <th style="text-align: center;">RESULTS</th> 
                    </tr>
                    <tr>
                      <td>Sent</td>
                      <td>{{session('share_analytics')->sent}}</td>
                    </tr>
                    <tr>
                      <td>Email Open</td>
                      <td>{{session('share_analytics')->opens}}</td>
                    </tr>
                    <tr>
                      <td>Clicks</td>
                      <td>{{session('share_analytics')->clicks}}</td>
                    </tr>
                    <tr>
                      <td>Reject</td>
                      <td>{{session('share_analytics')->rejects}}</td>
                    </tr>
                    <tr>
                      <td>Unsubscribe</td>
                      <td>{{session('share_analytics')->unsubs}}</td>
                    </tr>
                    <tr>
                      <td>Soft Bounce</td>
                      <td>{{session('share_analytics')->soft_bounces}}</td>
                    </tr>
                    <tr>
                      <td>Hard Bounce</td>
                      <td>{{session('share_analytics')->hard_bounces}}</td>
                    </tr>
              </table>
              <style>
                  table, th, td {
                      border: 1px solid black;
                      border-collapse: collapse;
                  }
                  th, td {
                      padding: 5px;
                      text-align: left;
                  }
                  table#t01 {
                      width: 100%;    
                      background-color: #f1f1c1;
                  }
              </style>
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_analytics.css">
@endsection

@section("script")

@endsection