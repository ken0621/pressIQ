@extends("press_admin.admin")
@section("pressview")
<style type="text/css">
  .table-view
  {
    overflow-y: scroll;
    height: 500px;
  }
</style>
<div class="background-container">
    <div class="pressview">
    	<div class="pressview">
    	  <div class="table-view">
              <table style="width:100%;">
                    <tr>
                      <th style="text-align: center;width: 20%">Date / Time </th>
                      <th style="text-align: center;width: 20%">Title / Subject</th>
                      <th style="text-align: center;width: 15%">Status </th>
                      <th style="text-align: center;width: 35%">Recipients</th>
                      <th style="text-align: center;width: 20%">No. Email Open</th>
                      <th style="text-align: center;width: 15%">Clicks</th>
                    </tr>
                    @foreach($analytics_view as $view)
                    <tr>
                      <td>{{date("m-d-Y\ / h:i:s a",($view->ts))}} </td>
                      <td>{{$view-> subject}}</td>
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
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_admin_dashboard.css">
@endsection

@section("script")

@endsection
