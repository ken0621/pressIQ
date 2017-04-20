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
                        <small><span style="color: gray">My Slots in @if(isset($plan->marketing_plan_label)) {{$plan->marketing_plan_label}} @endif.</span></small>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th>Slot</th>
                                    <th>Upline</th>
                                    <th></th>
                                </thead>
                            <tbody>
                            @if(isset($slots_tri))
                                @foreach($slots_tri as $key => $value)
                                <tr>
                                    <td>
                                        {{$value->repurchase_slot_id}}
                                    </td>
                                    <td>
                                        {{$value->repurchase_slot_placement}}
                                    </td>
                                    <td></td>
                                </tr>
                                @endforeach
                            @else
                            <tr><td colspan="20"><center>No Slots In @if(isset($plan->marketing_plan_label)) {{$plan->marketing_plan_label}} @endif</center></td></tr>
                            @endif
                            </tbody>
                             </table>
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