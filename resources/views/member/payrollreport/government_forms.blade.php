@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Payroll Reports &raquo; Government Forms</span>
                <small>
                Filter different forms for Government
                </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-3">
                <select class="form-control contribution-month">
                    <option>2017</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group tab-content panel-body employee-container">
            <div id="all" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Month Name</th>
                                <th class="text-center">No. of Processed Period</th>
                                <th width="100px" class="text-center"></th>
                                <th width="100px"></th>
                                <th width="100px"></th>
                            </tr>
                        </thead>
                        <tbody class="table-warehouse">
                            @foreach($_month_period as $key => $period)
                            <tr>
                                <td>{{ $period["month_name"] }}</td>
                                <td class="text-center">{{ $period["period_count"] }}</td>
                                @if($period["period_count"] != 0)
                                <td class="text-center"><a href="javascript: action_load_link_to_modal('/member/payroll/reports/government_forms_sss/{{ $key }}','lg')">SSS</a></td>
                                <td class="text-center"><a href="javascript: action_load_link_to_modal('/member/payroll/reports/government_forms_philhealth/{{ $key }}','lg')">PHILHEALTH</a></td>
                                <td class="text-center"><a href="javascript: action_load_link_to_modal('/member/payroll/reports/government_forms_hdmf/{{ $key }}','lg')">HDMF</a></td>
                                @else
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection
