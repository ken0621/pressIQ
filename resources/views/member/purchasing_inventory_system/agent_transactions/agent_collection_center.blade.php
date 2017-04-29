@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Agent Collection Center </span>
                <small>
                    Agent Collection List
                </small>
            </h1>
        </div>
    </div>
</div>

<!-- NO PRODUCT YET -->
<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <div class="form-group tab-content panel-body sir_container">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>SIR No</th>
                            <th>Agent Name</th>
                            <th>Total</th>
                            <th>Total Collection (On Hand)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($_sir)
                        @foreach($_sir as $sir)
                            <tr>
                                <td>{{sprintf("%'.04d\n", $sir->sir_id)}}</td>
                                <td>{{$sir->first_name." ".$sir->middle_name." ".$sir->last_name}}</td>
                                <td>{{$sir->total_collection}}</td>
                                <td></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu dropdown-menu-custom">
                                        <li><a></a></li>
                                      </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection