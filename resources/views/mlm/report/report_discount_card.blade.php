@extends('mlm.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        {!! $header !!}
        <div class="box box-primary">
            <div class="box-body">
                <div class="list-group">   
                        <div class="form-group">
                            <h4 class="section-title">
                            Unused Discount Card
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <th class="info" style="text-align: center;">Date Created</th>
                                    <th class="info" style="text-align: center;">Membership Name</th>
                                </thead>
                                @if(isset($unused_discount_car))
                                    @if(count($unused_discount_car) >= 1)
                                        @foreach($unused_discount_car as $key => $value)
                                            <tr>
                                                <td style="text-align: center;">{{$value->discount_card_log_date_created}}</td>
                                                <td style="text-align: center;">{{$value->membership_name}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="42"><center>No used discount card</center></td>
                                    </tr>
                                    @endif
                                @else
                                <tr>
                                    <td colspan="42"><center>No used discount card</center></td>
                                </tr>
                                @endif
                                </table>
                            </div>
                        </div>                 
                </div>
            </div>
        </div>


         <div class="box box-primary">
            <div class="box-body">
                <div class="list-group">
                        <div class="form-group">
                            <h4 class="section-title">
                            Used Discount Card
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <th class="info" style="text-align: center;">Date Created</th>
                                    <th class="info" style="text-align: center;"Membership Name</th>
                                    <th class="info" style="text-align: center;">Used On</th>
                                    <th class="info" style="text-align: center;">Date Used</th>
                                    <th class="info" style="text-align: center;">Expiration</th>
                                    <th class="info" style="text-align: center;">Discount Card Code <br> <span style="color: green;"><small>Show this code in the cashier</small></span></th>
                                </thead>
                                @if(isset($used_discount_card))
                                    @if(count($used_discount_card) >= 1)
                                        @foreach($used_discount_card as $key => $value)
                                            <tr>
                                                <td style="text-align: center;">{{$value->discount_card_log_date_created}}</td>
                                                <td style="text-align: center;">{{$value->membership_name}}</td>
                                                <td style="text-align: center;">{{$value->title_name}} {{$value->first_name}} {{$value->middle_name}} {{$value->last_name}} {{$value->suffix_name}}</td>
                                                <td style="text-align: center;">{{$value->discount_card_log_date_used}}</td>
                                                <td style="text-align: center;">{{$value->discount_card_log_date_expired}}</td>
                                                <td style="text-align: center;">{{$value->discount_card_log_code}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="42"><center>No used discount card</center></td>
                                    </tr>

                                    @endif
                                @else
                                <tr>
                                    <td colspan="42"><center>No used discount card</center></td>
                                </tr>
                                @endif
                                </table>
                            </div>
                        </div>                  
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
function  show_pop_up(discount_card_log_id) {
    console.log(1);
    var link = '/mlm/report/discount_card/use?discount_card_log_id=' + discount_card_log_id;

    action_load_link_to_modal(link, 'md');
}
</script>
@endsection