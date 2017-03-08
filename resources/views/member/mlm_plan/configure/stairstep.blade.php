@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Marketing Plan - Stairstep</span>
                <small>
                    You can set the computation of your Stairstep marketing plan here.
                </small>
            </h1>
            <a href="javascript:" class="panel-buttons btn btn-custom-blue pull-right" onClick="update_basic_settings()">Update</a>
            <a href="/member/mlm/plan" class="panel-buttons btn btn-custom-white pull-right"> < Back</a>
        </div>
    </div>
</div>
{!! $basic_settings !!}
<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <div class="tab-content">
        <div id="all-orders" class="tab-pane fade in active">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr><th colspan="6"><center>RANK BONUS</center></th></tr>
                        <!--<tr>-->
                        <!--    <th>RANK</th>-->
                        <!--    <th>LEVEL</th>-->
                        <!--    <th>REQUIRED PERSONAL SALES</th>-->
                        <!--    <th>REQUIRED GROUP SALES</th>-->
                        <!--    <th>BONUS</th>-->
                        <!--    <th></th>-->
                        <!--</tr>-->
                    </thead>
                    <tbody class="stair_body">
                        {!! $stair_get !!}
                        
                    </tbody>
                </table> 
            </div>  
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
load_stair();
function load_stair()
{
    $('.stair_body').html('<td colspan="6"><center><div style="margin: 100px auto;" class="loader-16-gray"></div></center></td>');
	   $('.stair_body').load('/member/mlm/plan/stairstep/get');
}
function save_stairstep()
{
 $('#save_stairstep').submit();   
}
function edit_stairstep(key)
{
    $('#edit_form' + key).submit();
}
</script>
@endsection
