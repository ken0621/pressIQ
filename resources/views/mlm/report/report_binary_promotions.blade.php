@extends('mlm.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        {!! $header !!}
        <form method="POST">
        <div class="panel panel-default panel-block">
            <div class="list-group">
                <div class="list-group-item" id="responsive-bordered-table">
                    <div class="form-group">
                        <h4 class="section-title">
                        @if(isset($plan->marketing_plan_label)) {{$plan->marketing_plan_label}} @endif
                        </h4>
                        <small><span style="color: gray"></span></small>
                        <div class="table-responsive">

                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product Name</th>
                                    <th>Required Binary <br> Points Left</th>
                                    <th>Current Left</th>
                                    <th>Required Binary <br> Points Right</th>
                                    <th>Current Right</th>
                                    <th>No. of units to be given</th>
                                    <th>No. of units taken</th>
                                    <td>Promo Start Date</td>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promotions as $key => $value)
                                <tr>
                                    <td><img src="{{ $value->item_img ? $value->item_img : "/assets/front/img/default.jpg" }}" style="width: 100%"></td>
                                    <td>{{$value->item_name}}</td>
                                    <td>{{$value->binary_promotions_required_left}}</td>
                                    <td>{{$current_l[$key]}}</td>
                                    <td>{{$value->binary_promotions_required_right}}</td>
                                    <td>{{$current_r[$key]}}</td>
                                    <td>{{$value->binary_promotions_no_of_units}}</td>
                                    <td>{{$value->binary_promotions_no_of_units_used}}</td>
                                    <td>{{$value->binary_promotions_start_date}}</td>
                                    <td>
                                    
                                            @if($value->binary_promotions_no_of_units > $value->binary_promotions_no_of_units_used)
                                                @if($current_l[$key] >= $value->binary_promotions_required_left)
                                                    @if($current_r[$key] >= $value->binary_promotions_required_right)
                                                        @if($req_count[$key] == 0)
                                                        <button class="btn btn-primary" form="form_{{$value->binary_promotions_id}}">Request</button>
                                                        @else
                                                        Already Claimed this promotion.
                                                        @endif
                                                    @else
                                                        Insufficient Points
                                                    @endif
                                                @else
                                                    Insufficient Points
                                                @endif
                                            @else
                                                All Stock Taken
                                            @endif
                                    </form>          
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="hide">
                        @foreach($promotions as $key => $value)    
                            @if($value->binary_promotions_no_of_units > $value->binary_promotions_no_of_units_used)
                                @if($current_l[$key] >= $value->binary_promotions_required_left)
                                    @if($current_r[$key] >= $value->binary_promotions_required_right)
                                        @if($req_count[$key] == 0)
                                        <form  id="form_{{$value->binary_promotions_id}}" method="post" action="/mlm/report/binary_promotions/request" class="global-submit">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="binary_promotions_id" value="{{$value->binary_promotions_id}}">
                                        </form>
                                        @else
                                        Already Claimed this promotion.
                                        @endif
                                    @else
                                        Insufficient Points
                                    @endif
                                @else
                                    Insufficient Points
                                @endif
                            @else
                                All Stock Taken
                            @endif
                        @endforeach    
                        </div>
                        </div>
                        </div>
                    </div>
                </div>              
            </div>
        </div> 
        
        </form> 
        <div>

    </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    @if(isset($s))
        @if($s == 'error')
            toastr.error('{{$m}}');
        @else
            toastr.success('{{$m}}');
        @endif
    @endif
</script>
@endsection