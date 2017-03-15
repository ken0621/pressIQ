@extends('member.layout')
@section('content')
<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tablet"></i>
            <h1>
                <span class="page-title">Tablet</span>
                <small>
                    Login as Sales Agent
                </small>
            </h1>
        </div>
        <div class="pull-right">
            <div class="col-md-12">
                <label>{{$employee_name}}</label><br>
                <label>{{$employee_position}}</label><br>
                <a href="/tablet/logout">Logout</a>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
            <!-- <div class="form-group">
                <div class="col-md-4">
                    <form class="global-submit form-to-submit-add" action="/tablet/sync_import" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit" class="btn btn-primary">Sync Import Data</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <form class="global-submit form-to-submit-add" action="/tablet/sync_export" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit" class="btn btn-primary">Sync Export Data</button>
                    </form>
                </div>
            </div> -->
        <div class="form-group tab-content panel-body sir_container">
            <div class="tab-pane fade in active">
                <div class="form-group order-tags">
                    <div class="col-md-12 text-center">
                      @if($sir != null)
                        <div class="form-group">
                            <div class="col-md-12">
                                <h3>Load Out Form No: <strong>{{sprintf("%'.05d\n", $sir->sir_id)}}</strong></h3>
                                <ul class="nav nav-tabs">
                                  <li id="all-list" class="active"><a data-toggle="tab" href="#all"><i class="fa fa-star" aria-hidden="true"></i>&nbsp;All List</a></li>
                                  <li id="checked"><a data-toggle="tab" href="#archived"><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;Checked</a></li>
                                  <li id="unchecked"><a data-toggle="tab" href="#archived"><i class="fa fa-square-o" aria-hidden="true"></i>&nbsp;Unchecked</a></li>
                                </ul>
                            </div>               
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                
                            </div>
                            <div class="col-md-12">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <a link="" size="md" class="popup btn btn-primary form-control">Confirm</a>
                            </div>
                            <div class="col-md-6">
                                <a link="" size="md" class="popup btn btn-primary form-control">Reject</a>
                            </div>
                        </div>
                      @else
                      <h2>You don't have any Load Out Form yet.</h2>
                      @endif  
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<script type="text/javascript">
    function submit_done(data)
    {
        if(data.status == "success")
        {
            toastr.success("Success");
            location.href = "/tablet/dashboard";
        }
        else if(data.status == "error")
        {
            toastr.warning(data.status_message);
            $(data.target).html(data.view);
        }
    }
</script>
@endsection