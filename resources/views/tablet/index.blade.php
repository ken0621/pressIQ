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
            <div class="form-group">
                <div class="col-md-6"><h4>List of Load Out Form issued to you</h4></div>
                @if($ctr_open_sir != 0)
                    <div class="col-md-6 text-right">
                        <a href="/tablet/sir_dashboard" class="btn btn-primary">Go to Dashboard ({{$ctr_open_sir}})</a>
                    </div>
                @endif
            </div>
        <div class="form-group tab-content panel-body sir_container">
            <div id="all" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead style="text-transform: uppercase">
                            <tr>
                                <th>SIR No</th>
                                <th>SIR Created</th>
                                <th>Truck Plate No</th>
                                <th>Sales Agent</th>
                                <th>Total Item</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @if($_sir)
                               @foreach($_sir as $sir)
                                    <tr>
                                        <td align="center">{{sprintf("%'.05d\n", $sir->sir_id)}}</td>
                                        <td>{{date('F d, Y', strtotime($sir->sir_created))}}</td>
                                        <td>{{$sir->plate_number}}</td>
                                        <td>{{$sir->first_name}} {{$sir->middle_name}} {{$sir->last_name}}</td>
                                        <td>{{$sir->total_item}}</td>
                                        <td>{{currency("PHP",$sir->total_amount)}}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action <span class="caret"></span>
                                              </button>
                                              @if($sir->sir_status == 0)
                                              <ul class="dropdown-menu dropdown-menu-custom">
                                                <li><a size="lg" link="/tablet/pis/sir/review/{{$sir->sir_id}}" class="popup">Review Load Out Form</a></li>
                                                <li><a size="md" link="/tablet/pis/sir/{{$sir->sir_id}}/confirm" class="popup">Confirm Load Out Form</a></li>
                                                <li><a size="md" class="popup" link="/tablet/pis/sir/{{$sir->sir_id}}/reject">Reject Load Out Form</a></li>
                                              </ul>
                                              @endif
                                            </div>
                                        </td>
                                    </tr>
                               @endforeach
                           @endif
                        </tbody>
                    </table>
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