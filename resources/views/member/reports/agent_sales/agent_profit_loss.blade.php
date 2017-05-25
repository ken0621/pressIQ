@extends('member.layout')

@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title"> Agent Profit & Loss</span>
            </h1>
        </div>
    </div>
</div>

@include('member.reports.filter.filter1');

<!-- NO PRODUCT YET -->
<div class="panel panel-default panel-block panel-title-block panel-gray">
    <div class="form-group tab-content panel-body sir_container">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>#</th>
                            <th>Agent Name</th>
                            <th>Sales</th>
                            <th>Discrepancy</th>
                            <th>ILR Losses</th>
                            <th>ILR Over</th>
                            <th>Total Discrepancy</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
