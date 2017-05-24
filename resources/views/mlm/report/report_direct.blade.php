@extends('mlm.layout')
@section('content')
{!! $header !!}


 <div class="box box-primary">
  <div class="box-body">
    <ul class="products-list product-list-in-box">
        @foreach($report as $key => $value)
          <li class="item">
            <div class="product-img">
              {!! mlm_profile($value) !!}
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">Sponsor: {{name_format_from_customer_info($value)}}
                <span class="label label-success pull-right">{{currency('PHP', $value->wallet_log_amount)}}</span></a>
                  <span class="product-description" style="color: black;">
                    {{$value->slot_no}}
                    <hr>
                    {{$value->wallet_log_details}}
                  </span>
            </div>
          </li>
        @endforeach  
      <!-- /.item -->
    </ul>
  </div>
  <!-- /.box-body -->
  <div class="box-footer text-center">
    <center>{!! $report->render() !!}</center> 
  </div>
  <!-- /.box-footer -->
</div>
@endsection