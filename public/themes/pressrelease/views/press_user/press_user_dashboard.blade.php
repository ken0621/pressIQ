@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="dashboard-container">
            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="title-container">RECENT RELEASES</div>
                </div>
                <div class="pull-right">
                    <div class="button-container">
                      <span class="create-button" ><a href="/pressuser/pressrelease">Create a Press Release</a>
                    </div>
                </div>
            </div>
           <div class="table-container">
              <table>
                  <tr>
                      <th>Press Release Title</th>
                      <th>Publish Date</th>
                      <th>Status</th>
                  </tr>
                  @foreach($pr as $prs)
                  <tr>
                      <td>{{$prs->pr_headline}}</td>
                      <td>{{$prs->pr_date_sent}}</td>
                      <td>{{$prs->pr_status}}</td>
                  </tr>
                  @endforeach
              </table> 
              {!! $pr->render() !!}
           </div>
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_dashboard.css">
@endsection

@section("script")
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:780031,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
@endsection