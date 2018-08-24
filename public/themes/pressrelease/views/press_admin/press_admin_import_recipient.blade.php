@extends("press_admin.admin")
@section("pressview")
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
<div class="background-container">
    <div class="pressview">
     
      @if($message = Session::get('Success'))
        <div class="alert alert-info alert-success fade in success_green" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <strong>Success!</strong> {{ $message }}
          </div>
      @endif     
      {!! Session::forget('Success') !!}
      <div class="dashboard-container">
        <div class="table-view ">
            <div class="container">
                <h1 style="font-size: 20px">Download Media Database Template</h1>
                <a href="{{ URL::to('downloadExcel/xls') }}"><button class="btn btn-success">Download Excel xls</button></a>
            </div><br><br>

            <div class="container">
                <h1 style="font-size: 20px">Upload New Media Database</h1>
                <form action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <input type="file" name="import_file" required><br>
                  <button class="btn btn-primary">Import your Excel File</button>
                </form>
            </div><hr>
            @if(Session::has('error_import'))
            <div class="container">
                <h1 style="font-size: 20px;color: red">Error List Found!</h1>
                <a href="/export/error/get">
                    <button type="button" class="btn btn-primary">Export Error</button>
                </a>
                <a href="/export/error/forget">
                    <button type="button" class="btn btn-danger">Forget Error</button>
                </a>
                
              </div>
            @endif
        </div>
      </div>
    </div>

</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_admin_dashboard.css">
@endsection

@section("script")

<script>
  setTimeout(function() 
  {
    $('.success_green').fadeOut('fast');
  }, 2000); 
</script>

@endsection
