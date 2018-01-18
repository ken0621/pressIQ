@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
            <!-- Dashboard -->
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="title-container">Results Found</div>
                </div>
                <div class="pull-right">
                    <div class="button-container">
                        <span class="create-button" ><a href="/pressuser/analytics">BACK</a>
                    </div>
                </div>
            </div>
              <table style="width:100%; ">
                    <tr>
                      <th style="text-align: center;width: 20%">Date / Time </th>
                      <th style="text-align: center;width: 15%">Status </th>
                      <th style="text-align: center;width: 35%">Recipients</th>
                      <th style="text-align: center;width: 20%">No. Email Open</th>
                      <th style="text-align: center;width: 15%">Clicks</th>
                    </tr>
                    @foreach($analytics_view as $view)
                    <tr>
                      <td>{{date("m-d-Y\ / h:i:s a",($view->ts))}} </td>
                      <td>{{$view-> state}}</td>
                      <td>{{$view-> email}}</td>
                      <td>{{$view-> opens}}</td>
                      <td>{{$view-> clicks}}</td>
                    </tr>
                    @endforeach
              </table>
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_analytics_view.css">
@endsection

@section("script")

@endsection