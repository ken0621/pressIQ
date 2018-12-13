@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-cart-plus"></i>
            <h1>
            <span class="page-title">{{$page}}</span>
            <small>
            List of Payment Type
            </small>
            </h1>
            <div class="dropdown pull-right">
                <button onclick="action_load_link_to_modal('/member/cashier/settings/add', 'lg')" class="btn btn-primary"><i class="fa fa-plus"></i> New list</button>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray">
    {{-- <ul class="nav nav-tabs">
        <li class="active change-tab pending-tab cursor-pointer" mode="pending"><a class="cursor-pointer go-default"><i class="fa fa-check"></i> Active</a></li>
        <li class="cursor-pointer change-tab approve-tab" mode="approved"><a class="cursor-pointer go-archive"><i class="fa fa-trash"></i> Archived</a></li>
    </ul>
    <div class="search-filter-box">
        <div class="col-md-3" style="padding: 10px">
            <select name="list_type_id" class="form-control filter-list-type">
                <option value="0">All Payment Type</option>
            </select>
        </div>
        
        <div class="col-md-4" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search-list-list" placeholder="Search list" aria-describedby="basic-addon1">
            </div>
        </div>
    </div> --}}
    <div class="tab-content codes_container" style="min-height: 300px;">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="clearfix">
                <div class="col-md-12">
                    <div class="table-responsive ">
                        @if(count($_list) > 0)
                        <table class="table table-bordered table-striped table-condensed">
                            <thead style="text-transform: uppercase">
                                <tr>
                                    <th class="text-center">Payment Name</th>
                                    <th class="text-left" width="170px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($_list as $list)
                                <tr>
                                    <td class="text-center">{{ $list->payment_name }}</td>
                                    
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-custom">
                                                <li>
                                                    <a onclick="action_load_link_to_modal('/member/cashier/settings/{{$list->payment_method_id}}', 'lg')">
                                                        <div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-edit"></i> &nbsp;</div>
                                                        Modify
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:" class="list">
                                                        <div style="display: inline-block; width: 17px; text-align: center;"><i class="fa fa-trash"></i> &nbsp;</div>
                                                        <span style="text-transform: capitalize;">Archive</span>
                                                    </a>
                                                </li>
                                                
                                                
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div style="padding: 100px; text-align: center;">NO DATA YET</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')

@endsection
@section('css')
<style type="text/css">
.wrapper.extended.scrollable
{
overflow: hidden;
}
</style>
@endsection