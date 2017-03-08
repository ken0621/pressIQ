@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Page Development Status</span>
                <small>
                    These are the status of development for every module.
                </small>
            </h1>
            <a href="javascript:" class="panel-buttons btn btn-default pull-right">Export Slots</a>
        </div>
    </div>
</div>

<!-- NO PRODUCT YET -->
<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <div class="tab-content">
        <div id="all-orders" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>Page</th>
                            <th class="text-left">Status</th>
                            <th class="text-right">Lead Developer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($_page as $page)
                        <tr>
                            <td><b>{{ $page["name"] }}</b></td>
                            <td class="text-left"></td>
                        </tr>

                            @if(!isset($page['url']))
                                 @foreach($page['submenu'] as $sub_page)
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i>  {{ $sub_page["label"] }}</td>
                                    <td class="text-left">{!! $sub_page["status"] !!}</td>
                                    <td class="text-right">{!! $sub_page["developer"] !!}</td>
                                </tr>
                                 @endforeach
                            @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
