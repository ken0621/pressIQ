@extends('member.layout')
@section('content')

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-heading">
        <div>
            <i class="fa fa-user-secret"></i>
            <h1>
                <span class="page-title">Utilities &raquo; position</span>
                <small>
                Add a position
                </small>
            </h1>
            <button type="button" class="panel-buttons btn btn-custom-primary pull-right popup" link="/member/utilities/modal-position" size="sm">Create Position</button>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    
    <ul class="nav nav-tabs">
        <li class="active cursor-pointer"><a class="cursor-pointer" data-toggle="tab"><i class="fa fa-star"></i> Active Position</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab"><i class="fa fa-trash"></i> Inactive Position</a></li>
    </ul>
    
    <div class="search-filter-box">
        <div class="col-md-3" style="padding: 10px">
            <select class="form-control">
                <option></option>
                <option></option>
                <option></option>
            </select>
        </div>
        <div class="col-md-4 col-md-offset-5" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search by Vendor Name" aria-describedby="basic-addon1">
            </div>
        </div>  
    </div>
    
    <div class="panel-body position-container">
        <table style="table-layout: fixed;" class="table table-hover table-condensed table-bordered table-sale-month">
            <thead>
                <tr>
                    <th class="text-left">Id</th>
                    @if($is_developer)
                        <th class="text-left">Shop Id</th>
                        <th class="text-left">Shop Name</th>
                        <th class="text-left">Shop Status</th>
                    @endif
                    <th class="text-left">Name</th>
                    <th class="text-left">Rank</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($_position as $position)
                <tr class="cursor-pointer">
                    <td class="text-left">{{$position->position_id}}</td>
                    @if($is_developer)
                        <td class="text-left">{{$position->shop_id}}</td>
                        <td class="text-left">{{$position->shop_key}}</td>
                        <td class="text-left">{{$position->shop_status}}</td>
                    @endif
                    <td class="text-left">{{$position->position_name}}</td>
                    <td class="text-left">{{$position->position_rank}}</td>
                    <td class="text-center">
                        <!-- ACTION BUTTON -->
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-custom">
                            <li><a href="/member/utilities/access?id={{$position->position_id}}">Edit</a></li>
                            <li><a href="#">Delete</li>
                          </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function submit_done(data)
    {
        //console.log("hello");
        // if(data.redirect_to)
        // {
        //     window.location.href = data.redirect_to;
        // }
        if(data.response_status == "success")
        {
            $(".position-container").load("/member/utilities/position .position-container");
            toastr.success('Success');
            $("#global_modal").modal("toggle");
        }

    }
    
</script>
@endsection