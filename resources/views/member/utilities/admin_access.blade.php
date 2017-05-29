@extends('member.layout')
@section('css')
<style>
  .single-space
  {
    padding-left: 30px;
  } 
  .double-space
  {
    padding-left: 60px;
  }
  .first
  {
    background-color: #ffffff;
  }
  .second
  {
    background-color: #ffffff;
  }
  .third
  {
    background-color: #ffffff;
    color: #76b6ec!important;
  }
  .hr
  {
    height: 4px;
    -webkit-box-shadow: inset 0 -3px 0 0 #76b6ec;
    box-shadow: inset 0 -3px 0 0 #76b6ec;
  }
</style>
@endsection
@section('content')
<form class="global-submit" action="/member/utilities/add-access" method="POST" >
<input type="hidden" name="_token" value="{{csrf_token()}}" >
<input type="hidden" name="position_id" value="{{Input::get('id','no position id selected')}}" >
<div class="panel panel-default panel-block panel-title-block">
  <div class="panel-heading">
    <div>
      <i class="fa fa-user-secret"></i>
      <h1>
        <span class="page-title">Utilities &raquo; access</span>
        <small>
        </small>
      </h1>
      <button type="submit" class="panel-buttons btn btn-custom-primary pull-right">Save Access</button>
    </div>
  </div>
</div>

<div id="menu" class="col-md-6">
  <div class="panel list-group">
    @foreach($_page as $key=>$page)
    <a href="#" class="list-group-item first" data-toggle="collapse" data-target="#{{$key}}" >
      <span class="label label-info">{{count($page['submenu'])}}</span>
      {{$page['name']}} 
    </a>
      @if(array_has($page,'submenu'))
        <div id="{{$key}}" class="sublinks collapse">
          <div class="hr"></div>
          <!-- FOREACH FOR SUBMENU -->
          @foreach($page['submenu'] as $key2=>$submenu)
            @if(array_has($submenu,'label'))
              <a class="list-group-item single-space second" {{ isset($submenu['user_settings']) ? "data-toggle=collapse data-target=#$key2" : '' }}>
                <span class="label label-info">{{count($submenu['user_settings'])}}</span>
                {!! $submenu['label'] !!}
              </a>
            @endif
            @if(array_has($submenu,'user_settings'))
              <div id="{{$key2}}" class="sublinks collapse">
                <!-- FOREACH FOR USER SETTINGS -->
                @foreach($submenu['user_settings'] as $key3=>$setting)
                  <a class="list-group-item double-space third">
                    <label class="checkbox">
                      <input class="form-group" type="checkbox" name="{{$submenu['code']."|".$setting}}" value="1" {{$submenu['setting_is_checked'][$key3] == 1 ? 'checked' : ''}}>
                      {{$setting}}
                    </lable>
                  </a>
                @endforeach
              </div>
            @endif
          @endforeach
        </div>
      @endif 
    @endforeach
</div>
</form>
@endsection
@section('script')
<script type="text/javascript">
    @if(Session::has('success'))
        toastr.success('{{Session::get('success')}}');
    @endif

    function submit_done(data)
    {
      if(data.response_status == 'success')
      {
        toastr.success(data.message);
      }
    }
</script>
@endsection