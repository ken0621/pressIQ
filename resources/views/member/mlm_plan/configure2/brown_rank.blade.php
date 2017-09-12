@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Marketing Plan - Brown Rank System</span>
                <small>
                    You can set the computation of your Brown Ranking.
                </small>
            </h1>
            <a href="javascript:" class="panel-buttons btn btn-custom-blue pull-right" onClick="update_basic_settings()">Update</a>
            <a href="/member/mlm/plan" class="panel-buttons btn btn-custom-white pull-right"> < Back</a>
        </div>
    </div>
</div>

<div class="bsettings">
    {!! $basic_settings !!}  
</div>

<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <div class="search-filter-box">
        <div class="col-md-8" style="padding: 10px">
        </div>
        <div class="col-md-4" style="padding: 10px; text-align: right;">
            <button class="btn btn-custom-white" onclick="action_load_link_to_modal('/member/mlm/plan/brown_rank/add_rank')"><i class="fa fa-plus"> </i> Add Rank</button>
        </div>
    </div>
    <div class="tab-content codes_container" style="min-height: 300px;">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="clearfix">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead style="text-transform: uppercase">
                                <tr>
                                    <th class="text-center">Order</th>
                                    <th class="text-center">Rank Name</th>
                                    <th class="text-center">Required Slots</th>
                                    <th class="text-center" width="300px">BUILDER REWARD</th>
                                    <th class="text-center" width="350px">LEADER REWARD (OVERRIDING)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">Dealer</td>
                                    <td class="text-center">NO REQUIREMENTS</td>
                                    <td class="text-center">NO GROUP PURCHASE</td>
                                    <td class="text-center">NO PASSUP</td>
                                    <td class="text-center"><a class="text-center" href="">MODIFY</td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td class="text-center">Builder</td>
                                    <td class="text-center">25 SLOTS UP TO 5TH LEVEL</td>
                                    <td class="text-center">3% OF GROUP PURCHASE UP TO 5TH LEVEL</td>
                                    <td class="text-center">NO PASSUP</td>
                                    <td class="text-center"><a class="text-center" href="">MODIFY</td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td class="text-center">Leader</td>
                                    <td class="text-center"><b>50</b> SLOTS UP TO <b>5TH LEVEL</b></td>
                                    <td class="text-center"><b>3%</b> OF GROUP PURCHASE UP TO <b>5TH LEVEL</b></td>
                                    <td class="text-center">
                                        <div><b>10%</b> OF GROUP BUILDER REWARD UP TO <b>5TH LEVEL</b></div>
                                        <div><b>10%</b> OF GROUP DIRECT REFERRAL UP TO <b>5TH LEVEL</b></div>
                                    </td>
                                    <td class="text-center"><a class="text-center" href="">MODIFY</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
