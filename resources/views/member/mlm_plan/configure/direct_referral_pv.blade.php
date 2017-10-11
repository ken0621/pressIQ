@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Marketing Plan - Direct Referral PV</span>
                <small>
                    You can set the computation of your direct marketing plan here.
                </small>
            </h1>
            <a href="javascript:" class="panel-buttons btn btn-custom-blue pull-right" onClick="update_basic_settings()">Update</a>
            <a href="/member/mlm/plan" class="panel-buttons btn btn-custom-white pull-right">  Back</a>
        </div>
    </div>
</div>
{!! $basic_settings !!} 
<div class="panel panel-default">
  <div class="panel-body">

    <form class="global-submit" method="post" id="save_include" action="/member/mlm/plan/direct_referral_pv/edit/save_include_direct_referral">
        {!! csrf_field() !!}
        <div class="col-md-12 pull">
            <label for="direct_referral_pv_initial_rpv">Include Self Slot to have a pv</label>
            <input type="checkbox" id="direct_referral_pv_initial_rpv" name="direct_referral_pv_initial_rpv" value="1" {{$direct_referral_pv_initial_rpv == 1 ? 'checked' : ''}}>
        </div> 
        <div class="col-md-1 pull-right">
            <a data-toggle="tooltip" data-placement="left" title="Tooltip on left" href="javascript:" onClick="save_include()">Save</a>
        </div> 
    </form>       

  </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <div class="tab-content">
        <div id="all-orders" class="tab-pane fade in active">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr><th colspan="3"><center>DIRECT SPONSOR BONUS PER MEMBERSHIP</center></th></tr>
                        <tr>
                            <th>MEMEBERSHIP NAME</th>
                            <th>REFERRAL RANK PV</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($membership))
                            @if(!empty($membership))
                                @foreach($membership as $key => $mem)
                                    <tr>
                                        <td>{{$mem->membership_name}}</td>
                                            <form id='form{{$mem->membership_id}}' action='/member/mlm/plan/binary/edit/membership/points' method='post' class='global-submit'>
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="membership_id" value="{{$mem->membership_id}}">
                                                <input type='hidden' class='form-control direct_referral_rpv_container' name='direct_referral_rpv' value=''>
                                            </form>
                                            <td>
                                                <span class="direct_referral_rpv{{$mem->membership_id}}">{{$mem->direct_referral_rpv == "" ? 0 : $mem->direct_referral_rpv }}</span>
                                            </td>                                      
                                        <td>
                                            <span class="direct_referral_rpv_edit{{$mem->membership_id}}">
                                                <a data-toggle="tooltip" data-placement="left" title="Tooltip on left" href="javascript:" onClick="edit_direct_referral_rpv({{$mem->membership_id}},{{$mem->direct_referral_rpv}})">Edit</a>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="3"><center>No Active Membership</center></td>
                            </tr>
                            @endif
                        @endif
                    </tbody>
                </table> 
            </div>  
        </div>
    </div>
</div>  
@endsection

@section('script')
<script type="text/javascript">
function save_include()
{
 $('#save_include').submit();   
}
function save_direct_points_membership(membershipid)
{
    var direct_referral_rpv      = $('.direct_referral_rpvinput' + membershipid).val();
    $(".direct_referral_rpv_container").val(direct_referral_rpv);

    console.log($('#form' + membershipid));
    $('#form' + membershipid).submit();
    cancel(membershipid);
}
function cancel(membershipid)
{
    var direct_referral_rpv = $('.direct_referral_rpvinput' + membershipid).val();
    direct_referral_rpv = parseInt(direct_referral_rpv);

    console.log(Number.isInteger(direct_referral_rpv));

    if(Number.isInteger(direct_referral_rpv) == true)
    {
        console.log(direct_referral_rpv);
        $('.direct_referral_rpv' + membershipid).html(direct_referral_rpv);
        
        var edit = '<a data-toggle="tooltip" data-placement="left" title="Tooltip on left" href="javascript:" onClick="edit_direct_referral_rpv('+membershipid+', '+direct_referral_rpv+')">Edit</a>';
        $('.direct_referral_rpv_edit' + membershipid).html(edit)
    }
}
function edit_direct_referral_rpv(membershipid,direct_referral_rpv)
{
    $('.direct_referral_rpv' + membershipid).html("<input type='number' class='form-control direct_referral_rpvinput"+ membershipid +"' name='direct_referral_rpv' value='"+direct_referral_rpv+"'>");

    $('.direct_referral_rpv_edit' + membershipid).html('<a data-toggle="tooltip" data-placement="left" title="Tooltip on left" href="#" onClick="save_direct_points_membership(' + membershipid +')">Save</a>');
}
</script>
@endsection
