@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Product Points </span>
                <small>
                    You can set the points of your product here.
                </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="form-group">
                <form class="global-submit" method="post" action="/member/mlm/product/set/all/points">
                {!! csrf_field() !!}
                <div class="col-md-12 table-responsive">
                    <div class="col-md-12"><center>Set Points/Bonus For All Item</center></div>
                    <div class="col-md-3 hide">
                       <label>Membership</label>
                        <select class="form-control" name="membership_id">
                        @foreach($membership_active as $key => $value)
                            <option  value="{{$value->membership_id}}">{{$value->membership_name}}</option>
                        @endforeach
                        </select> 
                    </div>
                    <div class="col-md-4">
                        <label>Plan</label>
                        <select class="form-control" name="marketing_plan_code_id">
                            @foreach($active_plan_product_repurchase as $key => $value)
                                <option value="{{$value->marketing_plan_code_id}}">{{$value->marketing_plan_label}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Percentage of price</label>
                        <input type="number" class="form-control" value="0" name="percentage">
                    </div>
                    <div class="col-md-4">
                        <label>Set Points</label><br>
                        <button class="btn btn-primary col-md-12">Submit</button>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>
                </form>

                <div class="col-md-12 table-responsive">

                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>Show in repurchase</th>
                                <th></th>
                                <th class="text-center">
                                    Name
                                </th>
                               
                                <th class="text-center">
                                    SKU
                                </th>
                                @if(isset($active_label))
                                    @foreach($active_label as $key => $value)
                                        <th class="text-center">{{$value}}</th>
                                    @endforeach
                                @endif
                                <th>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tbl-filter">
                        @foreach($item as $variant)
                        <tr>
                            <td>
                                <form class="global-submit" id="show_mlm_{{$variant['item_id']}}" action="/member/item/edit/show/mlm" method="post">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="item_id" value="{{$variant['item_id']}}">
                                    <input type="checkbox" class="show_in_mlm_check" item_id="{{$variant['item_id']}}" name="item_show_in_mlm" value="1" @if($variant['item_show_in_mlm'] == 1) checked @endif>
                                </form>
                                
                            </td>
                            <td class="text-center">
                                <img src="{{$variant['item_img']}}" class="img-50-50"></img>
                            </td>
                            <td class="text-center">
                                <a href="javascript:" class="popup" size="lg" link="/member/item/edit/{{$variant['item_id']}}">{{$variant['item_name']}}</a><Br>
                            </td>
                            <td class="text-center">
                                {{$variant['item_sku']}}
                            </td>
                            @if(isset($active))
                                <form class="global-submit" method="post" id="formvariant{{$variant['item_id']}}" action="/member/mlm/product/point/add">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="item_id" value="{{$variant['item_id']}}">
                                    @foreach($active as $key => $value)
                                        <td><input type="number" class="form-control" name="{{$value}}" value="{{$variant[$value]}}"></td>
                                    @endforeach
                                </form>    
                            @endif
                            <td>
                              <a href="javascript:" class="pull-right" onClick="save_product_points({{$variant['item_id']}})" >Save</a>  
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12 text-center">
                    {!!$_inventory->render()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function save_product_points(item_id)
    {
        $('#formvariant'+ item_id).submit();   
    }
    function submit_done(data)
    {
        console.log(data);
        if(data.response_status == "success_edit_points")
    	{
    	    toastr.success('Success! Points Editted');
    	}
        else if(data.response_status == "success_edit_all_points")
        {
            toastr.success('All Product Points Updated');
            location.reload();
        }

    }
    $('.show_in_mlm_check').on('change', function(ito){
        console.log(ito.currentTarget.attributes.item_id);
        var item_id = ito.currentTarget.attributes.item_id.value;
        console.log(item_id);
        $('#show_mlm_' + item_id).submit();
    })
</script>
@endsection
