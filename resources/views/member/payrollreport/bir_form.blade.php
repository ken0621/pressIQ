@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Payroll Reports &raquo; BIR Forms</span>
                <small>
                Filter different forms for BIR
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
                    @foreach($_year_period as $year)
                        <option value="{{$year["year_contribution"]}}" {{$year["year_contribution"] == $year_today ? 'selected': 'unselected'}}>{{$year["year_contribution"]}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="load-filter-datas">
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group tab-content panel-body employee-container">
            <div id="all" class="tab-pane fade in active">
                <div class="form-group order-tags"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-warehouse">
                            @foreach($_month as $key => $month)
                            <tr>
                                <td>{{ $month["month_name"] }}</td>
                                <td>{{}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>
</div>@endsection