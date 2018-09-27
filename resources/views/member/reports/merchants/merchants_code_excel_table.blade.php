<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <h2 class="text-center">{{$shop_name}}</h2>
    <h4 class="text-center"><b>{{$head_title." - ".$sheet_name}}</b></h4>
    <h4 class="text-center"><b>{{$warehouse_name}}</b></h4>
    <h4 class="text-center">{{isset($from) && $from != '1000-01-01' ? dateFormat($from)." - ".dateFormat($to) : 'All Dates'}}</h4>

    <table class="table">
      <thead class="thead-light">
        <tr>
          <tr>
            <th class="text-dark" scope="col">PIN</th>
            <th class="text-dark" scope="col">ACTIVATION</th>
            <th class="text-dark" scope="col">ITEM NAME</th>
            <th class="text-dark" scope="col">DATE</th>
            @if($status == '_distributed' || $status == '_released')
            <th class="text-dark" scope="col">VIP NAME</th>
            <th class="text-dark" scope="col">RECEIPT NUMBER</th>
            <th class="text-dark" scope="col">AMOUNT</th>
            <th class="text-dark" scope="col">CELLPHONE NO</th>
            <th class="text-dark" scope="col">EMAIL</th>
            @endif
          </tr>
        </tr>
      </thead>
      <tbody>
        @if(isset($return))
          @foreach($return as $key => $value)
          <tr>
              <td class="text-center">{{$value->mlm_pin}}</td>
              <td class="text-center">{{$value->mlm_activation}}</td>
              <td class="text-center">{{$value->item_name}}</td>
              <td class="text-center">{{date('m/d/Y', strtotime($value->record_log_date_updated))}}</td>
               @if($status == '_distributed' || $status == '_released')
              <td class="text-dark" scope="col">{{ucfirst($value->title_name." ".$value->first_name." ".$value->middle_name." ".$value->last_name." ".$value->suffix_name)}}</td>
              <td class="text-dark" scope="col">{{$value->receipt_number}}</td>
              <td class="text-dark" scope="col">{{ intval(preg_replace('/[^0-9]+/', '', $value->item_name), 10)}}</td>
              <td class="text-dark" scope="col">{{$value->cellphone_number}}</td>
              <td class="text-dark" scope="col">{{$value->email}}</td>
              @endif
          </tr>
          @endforeach
        @else
          <tr> ===== NO DATA FOUND =====</tr>
        @endif
      </tbody>
    </table>
</html>