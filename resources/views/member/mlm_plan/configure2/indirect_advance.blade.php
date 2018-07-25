@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Marketing Plan - Indirect Settings</span>
                <small>
                    You can set the computation of your Indirect Here.
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
        <div class="col-md-12" style="padding: 10px">
            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>MEMBERSHIP</th>
                        <th class="text-center">LEVEL</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($membership as $mem)
                    <tr>
                        <td>{{ $mem->membership_name }}</td>
                        <td class="text-center">{{ $mem->level or "0" }} LEVEL/S</td>
                        <td class="text-center"><a href="/member/mlm/plan/INDIRECT_ADVANCE/{{ $mem->membership_id }}">CONFIGURE</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-content codes_container" style="min-height: 300px;">
    </div>
</div>
@endsection
@section('script')
@endsection