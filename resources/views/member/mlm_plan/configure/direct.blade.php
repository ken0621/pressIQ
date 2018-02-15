@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Marketing Plan - Direct</span>
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
@include('member.mlm_plan.notes.direct')
<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <div class="tab-content">
        <div id="all-orders" class="tab-pane fade in active">
            <div class="table-responsive">
               
                <table class="table table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr><th colspan="3"><center>DIRECT SPONSOR BONUS PER MEMBERSHIP</center></th></tr>
                        <tr>
                            <th>MEMEBERSHIP NAME</th>
                            <th>DIRECT SPONSOR BONUS</th>
                            <th>DIRECT INCOME LIMIT</th>
                            <th>GC INCOME</th>
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
                                                <input type='hidden' class='form-control membership_points_direct_container' name='membership_points_direct' value=''>
                                                <input type='hidden' class='form-control membership_direct_income_limit_container' name='membership_direct_income_limit' value=''>
                                                <input type='hidden' class='form-control membership_points_direct_gc_container' name='membership_points_direct_gc' value=''>
                                            </form>
                                            <td>
                                                <span class="membership_points_direct{{$mem->membership_id}}">{{$mem->membership_points_direct == "" ? 0 : $mem->membership_points_direct }}</span>
                                            </td>                                      
                                            <td>
                                                <span class="membership_points_direct_limit{{$mem->membership_id}}">{{$mem->membership_direct_income_limit == "" ? 0 : $mem->membership_direct_income_limit }}</span>
                                            </td>                                            
                                            <td>
                                                <span class="membership_points_direct_gc{{$mem->membership_id}}">{{$mem->membership_points_direct_gc == "" ? 0 : $mem->membership_points_direct_gc }}</span>
                                            </td>
                                        <td>
                                            <span class="membership_points_direct_edit{{$mem->membership_id}}">
                                                <a data-toggle="tooltip" data-placement="left" title="Tooltip on left" href="javascript:" onClick="edit_direct_points('{{$mem->membership_id}}','{{$mem->membership_points_direct}}', '{{$mem->membership_direct_income_limit}}','{{$mem->membership_points_direct_gc}}')">Edit</a>
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



<div class="panel panel-default panel-block panel-title-block panel-gray advance-mode-content hidden">
    <div class="tab-content">
        <div class="tab-pane fade in active">
            <div class="row">
                <div class="col-md-12 table-responsive" style="padding: 30px;">
                    <form class="form-combinations">
                        {{ csrf_field() }}
                        <table class="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: center; font-size: 16px;" colspan="{{ count($membership) + 2 }}">
                                        ADVANCE DIRECT REFERRAL
                                    </th>
                                </tr>
                                <tr>
                                    <th></th>
                                    @foreach($membership as $key => $mem)
                                    <th class="text-center">{{$mem->membership_name}}</th>
                                    @endforeach
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($membership as $key => $mem_parent)
                                <tr class="membership-combinations">
                                    <td>{{$mem_parent->membership_name}}</td>
                                    @foreach($membership as $key => $mem_new_entry)
                                    <td><input name="direct_advance_bonus[]" type="text" class="form-control text-center" value="{{ $_advance[$mem_parent->membership_id][$mem_new_entry->membership_id] or 0 }}" placeholder="0.00"></td>
                                    <input type="hidden" name="direct_membership_parent[]" value="{{ $mem_parent->membership_id }}">
                                    <input type="hidden" name="direct_membership_new_entry[]" value="{{ $mem_new_entry->membership_id }}">
                                    @endforeach
                                    <td class="text-right"><button type="button" class="btn btn-primary save-combination"><i class="fa fa-save"></i></button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>

<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <div class="tab-content">
        <div class="tab-pane fade in active">
            <div class="row">
                <div class="col-md-12">
                    <select class="form-control select-advance-mode">
                        <option value="0" {{ $plan->advance_mode == 0 ? 'selected' : '' }}>Default Direct Bonus</option>
                        <option value="1" {{ $plan->advance_mode == 1 ? 'selected' : '' }}>Advance Direct Bonus</option>
                    </select>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection




@section('script')
<script type="text/javascript">

event_save_combination();
event_change_mode();
action_check_mode_show_hide_view();

function event_change_mode()
{
    $(".select-advance-mode").change(function()
    {
        action_check_mode_show_hide_view();
        action_save_mode();
    });
}

function action_save_mode()
{
    $.ajax(
    {
        url:"/member/mlm/plan/advance_mode",
        dataType:"json",
        data: { "advance_mode": $(".select-advance-mode").val(), "plan" : "DIRECT" },
        type:"get",
        success: function(data)
        {

        }
    });
}

function action_check_mode_show_hide_view()
{
    if($(".select-advance-mode").val() == 1)
    {
        $(".advance-mode-content").removeClass("hidden");
    }
    else
    {
        $(".advance-mode-content").addClass("hidden");
    }
}

function event_save_combination()
{
    $(".save-combination").click(function()
    {
        action_save_combination();
        return false;
    });
}

function action_save_combination()
{
    $(".save-combination").html("<i class='fa fa-spinner fa-pulse'></i>");

    $.ajax(
    {
        url:"/member/mlm/plan/direct/advance",
        dataType:"json",
        data: $(".form-combinations").serialize(),
        type: "post", 
        success: function(data)
        {
            toastr.success('Has been successfully configured!', 'Advance Direct Referral')
            $(".save-combination").html("<i class='fa fa-save'></i>");
        }
    });
}

function save_direct_points_membership(membershipid)
{
    var directpoints      = $('.membership_points_directinput' + membershipid).val();
    var directlimitpoints = $('.membership_points_direct_limitinput' + membershipid).val();
    var directpointsgc    = $('.membership_points_direct_gcinput' + membershipid).val();
    $(".membership_points_direct_container").val(directpoints);
    $(".membership_direct_income_limit_container").val(directlimitpoints);
    $(".membership_points_direct_gc_container").val(directpointsgc);

    console.log($('#form' + membershipid));
    $('#form' + membershipid).submit();
    cancel(membershipid);
}
function cancel(membershipid)
{
    var directpoints = $('.membership_points_directinput' + membershipid).val();
    var directlimitpoints = $('.membership_points_direct_limitinput' + membershipid).val();
    var directpointsgc = $('.membership_points_direct_gcinput' + membershipid).val();
    directpoints = parseInt(directpoints);
    directlimitpoints = parseInt(directlimitpoints);
    directpointsgc = parseInt(directpointsgc);

    console.log(Number.isInteger(directpoints));
    console.log(Number.isInteger(directlimitpoints));

    if(Number.isInteger(directpoints) == true && Number.isInteger(directlimitpoints) == true)
    {
        console.log(directpoints);
        console.log(directlimitpoints);
        $('.membership_points_direct' + membershipid).html(directpoints);
        $('.membership_points_direct_limit' + membershipid).html(directlimitpoints);
        $('.membership_points_direct_gcinput' + membershipid).html(directpointsgc);
        
        var edit = '<a data-toggle="tooltip" data-placement="left" title="Tooltip on left" href="javascript:" onClick="edit_direct_points('+membershipid+', '+directpoints+','+directlimitpoints+','+directpointsgc+')">Edit</a>';
        $('.membership_points_direct_edit' + membershipid).html(edit)
    }
}
function edit_direct_points(membershipid,directpoints,income_limit,gc)
{
    $('.membership_points_direct' + membershipid).html("<input type='number' class='form-control membership_points_directinput"+ membershipid +"' name='membership_points_direct' value='"+directpoints+"'>");
    $('.membership_points_direct_limit' + membershipid).html("<input type='number' class='form-control membership_points_direct_limitinput"+ membershipid +"' name='membership_direct_income_limit' value='"+income_limit+"'>");
    $('.membership_points_direct_gc' + membershipid).html("<input type='number' class='form-control membership_points_direct_gcinput"+ membershipid +"' name='membership_points_direct_gc' value='"+gc+"'>");

    $('.membership_points_direct_edit' + membershipid).html('<a data-toggle="tooltip" data-placement="left" title="Tooltip on left" href="#" onClick="save_direct_points_membership(' + membershipid +')">Save</a>');
}
</script>
@endsection
