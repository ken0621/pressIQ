 <div class="table_body_get"> 
   <div class="box box-primary">
    <div class="box-body">
      <ul class="products-list product-list-in-box">
        @if(isset($report))
          @foreach($report as $key => $value)
            <li class="item">
              <div class="product-img">
                {!! mlm_profile($value) !!}
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">Sponsor: {{name_format_from_customer_info($value)}}
                  <h4><span class="label label-success pull-right">{{currency('PHP', $value->wallet_log_amount)}}</span></h4></a>
                    <span class="product-description" style="color: black;">
                      Slot: {{$value->slot_no}}
                      <br>
                      Notification: {{$value->wallet_log_details}}
                      <br>
                      Level: {{$value->placement_level}}
                    </span>
              </div>
            </li>
          @endforeach  
      @endif    
      </ul>
    </div>
    <div class="box-footer text-center">
      <?php $search_slot = Request::input('search_slot'); ?>
      @if(isset($report))
        @if($search_slot)
        <center>{!! $report->appends(['search_slot' => $search_slot])->render() !!}</center> 
        @else
        <center>{!! $report->render() !!}</center> 
        @endif
      @endif
    </div>
  </div>

</div>