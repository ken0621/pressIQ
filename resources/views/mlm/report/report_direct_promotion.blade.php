@extends('mlm.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        {!! $header !!}
        <form method="POST">
        <div class="box box-primary">
            <div class="box-body">
                <div class="list-group">
                    @if(isset($membership))
                        <div class="form-group">
                            <h4 class="section-title">
                            @if(isset($plan->marketing_plan_label)) {{$plan->marketing_plan_label}} @endif
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <th class="info" style="text-align: center;">Membership</th>
                                        <th class="info" style="text-align: center;">Required Direct Referral</th>
                                        <th class="info" style="text-align: center;">Current</th>
                                        <th class="info" style="text-align: center;">Matched</th>
                                        <th class="info" style="text-align: center;">Bonus Type</th>
                                        <th class="info" style="text-align: center;">Count / Bonus</th>
                                    </thead>
                                    <tbody>
                                        @foreach($membership as $key => $value)
                                        <tr>
                                            <td style="text-align: center;">{{$value->membership_name}}</td>
                                            <td style="text-align: center;">{{$direct_promotion[$key]->settings_direct_promotions_count}}</td>
                                            <td style="text-align: center;">{{$count_direct[$key] - ($count_matched[$key] * $direct_promotion[$key]->settings_direct_promotions_count)}}</td>
                                            <td style="text-align: center;">{{$count_matched[$key] * $direct_promotion[$key]->settings_direct_promotions_count}} </td>
                                            <td style="text-align: center;">{{$direct_promotion[$key]->settings_direct_promotions_type == 0 ? 'Discount Card' : 'GC' }}</td>
                                            <td style="text-align: center;">{{$direct_promotion[$key]->settings_direct_promotions_bonus}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <center>No Active Report.</center>  
                    @endif                 
                </div>
        </div> 
        </div>
        
        </form> 
        <div>

    </div>
    </div>
</div>
@endsection