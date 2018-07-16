@extends('member.layout')
@section('content')
<form method="post">
    {{ csrf_field() }}
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">Marketing Plan - Indirect Settings</span>
                    <small>
                        Settings for Indirect
                    </small>
                </h1>
                <button class="btn btn-primary pull-right" style="margin-left: 10px;">UPDATE INDIRECT FOR {{ strtoupper($parent_membership->membership_name) }} </button>
                <a href="/member/mlm/plan/INDIRECT_ADVANCE" class="panel-buttons btn btn-custom-white pull-right"> < Back</a>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-block panel-title-block panel-gray clearfix ">
        <div class="search-filter-box">
            <div class="col-md-12" style="padding: 10px">
                <table class="table table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th colspan="{{ count($membership) + 1 }}" class="text-center">{{ strtoupper($parent_membership->membership_name) }}</th>
                        </tr>
                        <tr>
                            <td colspan="{{ count($membership) + 1 }}"><input class="form-control text-center enter-level-membership" type="text" placeholder="ENTER NUMBER OF LEVELS" name=""></td>
                        </tr>
                        <tr>
                            <th class="text-center" style="width: 100px;">LEVEL</th>
                            @foreach($membership as $mem)
                            <th class="text-center">{{ strtoupper($mem->membership_name) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bonus-container">
                        @if($_bonus)
                            @foreach($_bonus as $level => $bonus)
                            <tr>
                                <td class="text-center level" style="width: 100px;">{{ $level }}</td>
                                @foreach($membership as $mem)
                                <td class="text-center bonus-membership" membership_id="{{ $mem->membership_id }}"><input name="bonus[{{ $level }}][{{ $mem->membership_id }}]" value="{{ $bonus[$mem->membership_id] }}" class="form-control text-center text-bonus" type="text"></td>
                                @endforeach
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td class="text-center" colspan="{{ count($membership) + 1 }}"> NO DATA YET</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-content codes_container" style="min-height: 300px;">
        </div>
    </div>
</form>
<div class="hidden">
    <table>
        <tbody class="per-level-row-script">
            <tr>
                <td class="text-center level" style="width: 100px;">1</td>
                @foreach($membership as $mem)
                <td class="text-center bonus-membership" membership_id="{{ $mem->membership_id }}"><input value="0" class="form-control text-center text-bonus" type="text"></td>
                @endforeach
            </tr>
        </tbody>
    </table> 
</div>
@endsection
@section('script')
<script type="text/javascript">
    event_enter_level_membership();

    function event_enter_level_membership()
    {
        $(".enter-level-membership").keyup(function()
        {
            action_update_level_based_on_entered_key();
        });
    }

    function action_update_level_based_on_entered_key()
    {
        $level = $(".enter-level-membership").val();

        $(".bonus-container").html("");

        for($ctr = 1; $ctr <= $level; $ctr++)
        {
            $(".per-level-row-script").find(".level").text($ctr);
            $(".per-level-row-script").find(".bonus-membership").each(function(key, val)
            {
                $membership_id = $(this).attr("membership_id");
                $(this).find(".text-bonus").attr("name", "bonus[" + $ctr + "][" + $membership_id + "]");
            });

            $html = $(".per-level-row-script").html();

            $(".bonus-container").append($html);
        }
    }
</script>
@endsection