@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Unilevel Distribute</span>
                <small>
                    Convertion of unilevel points
                </small>
            </h1>
        </div>    
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <form class="global-submit" method="post" action="/member/mlm/complan_setup/unilevel/distribute/set/settings">
            {!! csrf_field() !!}
            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>
                            <label>Required Personal Points</label>
                            <input type="number" class="form-control" value="{{isset($settings_unilevel->u_r_personal) ? $settings_unilevel->u_r_personal : 0}}" name="u_r_personal">
                        </th>
                        <th>
                            <label>Required Group Points</label>
                            <input type="number" class="form-control" value="{{isset($settings_unilevel->u_r_group) ? $settings_unilevel->u_r_group : 0 }}" name="u_r_group">
                        </th>
                        <th>
                            <label>Convertion Points -> Wallet</label>
                            <input type="number" class="form-control" value="{{isset($settings_unilevel->u_r_convertion) ? $settings_unilevel->u_r_convertion : 0 }}" name="u_r_convertion">
                        </th>
                        <th>
                            <button class="btn btn-primary">Set Settings</button>
                        </th>
                    </tr>
                </thead>
            </table>
            </form>
            <!-- <hr> -->
            <table class="table table-condensed table-bordered">
                <thead>
                    <th>
                        <label>From</label>
                        <input type="date" class="form-control">
                    </th>
                    <th>
                        <label>TO</label>
                        <input type="date" class="form-control">
                    </th>
                    <th>
                        <button class="btn btn-primary">Simulate</button>
                    </th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>  
<div class="append_settings"></div>
@endsection
@section('script')
<script type="text/javascript">
    load_settings();
    function load_settings()
    {
        // $('.append_settings').html('<div style="margin: 100px auto;" class="loader-16-gray"></div>');
        // $('.append_settings').load('/member/mlm/plan/binary_promotions/get');
    }
    function submit_done(data)
    {
    	if(data.response_status == 'successd')
    	{
    		load_settings();
    		toastr.success(data.message);
    	}
    	else
    	{
    		load_settings();
    		toastr.error(data.message);
    	}
    }
</script>
@endsection