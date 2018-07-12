
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table class="table">
      <thead class="thead-light">
        <tr>
          <tr>
            <th class="text-dark" scope="col">PIN</th>
            <th class="text-dark" scope="col">ACTIVATION</th>
            <th class="text-dark" scope="col">ITEM NAME</th>
            <th class="text-dark" scope="col">DATE</th>
          </tr>
        </tr>
      </thead>
      <tbody>
        @if(isset($data))
          @foreach($data as $value)
          <tr>
              <td class="text-center">{{$value->mlm_pin}}</td>
              <td class="text-center">{{$value->mlm_activation}}</td>
              <td class="text-center">{{$value->item_name}}</td>
              <td class="text-center">{{date('m/d/Y', strtotime($value->record_log_date_updated))}}</td>
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>
</html>