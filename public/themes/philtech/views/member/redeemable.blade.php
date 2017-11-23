@extends("member.member_layout")

@section("member_content")
<div class="report-container" style="overflow: hidden;">
    <div class="report-header clearfix">
        <div class="animated fadeInLeft left">
            <div class="icon">
                <img src="/themes/{{ $shop_theme }}/img/report-icon.png">
            </div>
            <div class="text">
                    <div class="name">{{$page}}</div>
                    <div class="sub">Redeemable items are shown here. </div>
            </div>
        </div>
        <div class="animated fadeInRight right">
            <!-- <div class="search">
                <select class="form-control">
                    <option>All Slots</option>
                </select>
            </div> -->
        </div>
    </div>
    
    <div class="report-content">
        <div class="animated fadeInUp holder">
            <center>
            <div class="table-responsive">
                <center>
                @foreach($_redeemable as $redeemable)
                <div class="item-redeemable">
                    <img src="{{$redeemable->image_path}}" class="img-redeemable">
                    @if(strlen($redeemable->item_description)>30)
                    <div><h4><b>{{substr($redeemable->item_name,0,27)."..."}}</b></h4></div>
                    @else
                    <div><h4><b>{{$redeemable->item_name}}</b></h4></div>
                    @endif
                    <div><label>{{currency('',$redeemable->redeemable_points)." points"}}</label></div>
                    <!-- @if(strlen($redeemable->item_description)>30)
                    <div><label>{{substr($redeemable->item_description,0,27)."..."}}</label></div>
                    @else
                    <div><label>{{$redeemable->item_description}}</label></div>
                    @endif -->
                    <!-- <button class="btn-primary btn-primary btn-custom-primary" type="submit">Redeem</button> -->
                </div>
                @endforeach
                </center>
            </div>
            </center>
        </div>
    </div>

</div>
@endsection

@section("member_script")
@endsection

@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/redeemable.css">
@endsection


<!-- <table class="table">
                    <thead>
                        <tr>
                            @if(count($_redeemable)>0)
                            <th class="text-center" width="100px"></th>
                            <th class="text-center" width="200px">ITEM NAME</th>
                            <th class="text-left" width="100px">DESCRIPTION</th>
                            <th class="text-right" width="200px">REDEEM POINTS</th>
                            <th class="text-center" width="100px"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($_redeemable) > 0)
                            @foreach($_redeemable as $redeemable)
                            <tr>
                                <td class="text-center">
                                    <img src="{{$redeemable->image_path}}" class="img-redeemable">
                                </td>
                                <td class="text-center">
                                    <div><b>{{ $redeemable->item_name }}</b></div>
                                </td>
                                <td class="text-left">{{$redeemable->item_description}}</td>
                                <td class="text-right"><b>{{$redeemable->redeemable_points}}</b></td>
                                <td class="text-right"><button class="btn-primary btn-primary btn-custom-primary" type="submit">Redeem</button></td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="text-center" >
                                <td colspan="4">NO REDEEMABLE YET</td>
                            </tr>
                        @endif
                    </tbody>
                </table> -->