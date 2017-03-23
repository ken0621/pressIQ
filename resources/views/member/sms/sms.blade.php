@extends('member.layout')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-envelope"></i>
            <h1>
                <span class="page-title">Email Content</span>
                <small>
                    List of Email Content.
                </small>
            </h1>
            <div class="text-right row">
                <div class="col-md-4 pull-right">
                    <form class=""
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Authorization Key">
                        <span class="input-group-btn">
                            <button class="btn btn-custom-primary pane pul-buttons popup" link="/member/maintenance/email_content/add" type="button" size="md">Save SMS Key</button>
                        </span>
                    </div>  
                </div>                            
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal load-data">
        <div class="form-group tab-content panel-body sms-content-container">
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>SMS Content Key</th>
                            <th width="50%">SMS Content</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-warehouse">
                        @foreach($_sms as $key=>$sms)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$sms->sms_default_key}}</td>
                            <td>{{$sms->sms_temp_content or ''}}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a class="btn btn-primary btn-grp-primary popup" href="javascript:" link="/member/maintenance/sms/sms-modal/{{$sms->sms_default_key}}" size="md">Edit</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section("script")
<script type="text/javascript">
    function submit_done(data)
    {
        if(data.status == "success")
        {
            if(data.type == "sms")
            {
                $(".load-data").load("/member/maintenance/sms .sms-content-container", function()
                {
                    toastr.success(data.message);
                    data.element.modal("toggle");
                })   
            }
        }
    }

</script>
@endsection