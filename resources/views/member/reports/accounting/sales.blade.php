@extends('member.layout')

@section('css')
<link rel="stylesheet" href="/assets/member/css/customBTN.css" type="text/css" />
@endsection

@section('content')
{!! $head !!}
{!! $filter !!}
{!! $field_checker !!}
{!! $sales_report_by_customer !!}
<div class="panel panel-default panel-block panel-title-block hide">
    <div class="panel-heading">
        <div class="table-condensed">
            <table class="tbl tbl-bordered table-condensed">
                <thead>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('script')
@endsection