@extends("press_admin.admin")
@section("pressview")
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
<div class="background-container">
    <div class="pressview">
      @if($message = Session::get('success'))
        <div class="alert alert-info alert-success fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <strong>Success!</strong> {{ $message }}
          </div>
      @endif
      {!! Session::forget('success') !!}
      <div class="dashboard-container">
        <div class="title-container">Import Recipient File</div>
        <div class="table-view ">
          <div class="container">
              <form style="border: 4px solid #a1a1a1;margin-top: 10px;padding: 5px;width: 1000px" 
              action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="import_file" required><br>
                <button class="btn btn-primary">Import your File</button>
              </form>
            </div>
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
