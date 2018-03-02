@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
         @if (Session::has('delete'))
              <div class="alert alert-danger">
                 <center>{{ Session::get('delete') }}</center>
              </div>
          @endif 
        <div class="drafts-holder-container">
          <div class="table-container">
            <table>
                <tr>    
                    <th>Press Release Title</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                @foreach($drafts as $draft)
                <tr>
                    <td>{{$draft->pr_headline}}</td>
                    <td>Draft</td>
                    <td><a href="/pressuser/pressrelease/edit_draft/{{$draft->pr_id}}">Edit</a></td>
                    <td><a href="/pressuser/pressrelease/delete_draft/{{$draft->pr_id}}">Delete</a></td>
                </tr>
                @endforeach
            </table>
          </div>
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_drafts.css">
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