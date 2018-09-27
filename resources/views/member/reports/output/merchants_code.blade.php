<div class="report-container">
  <div class="panel panel-default panel-block panel-title-block panel-report load-data">
      <div class="panel-heading load-content">
         @include('member.reports.report_header')
         <div class="table-reponsive">
         		<table class="table table-condensed collaptable">
                    <thead >
                 		<tr>
                            <th class="text-center">PIN</th>
                 			<th class="text-center">ACTIVATION</th>
                 			<th class="text-center">ITEM NAME</th>
                            <th class="text-center">DATE</th>
                            <th class="text-center">NAME</th>
                            <th class="text-center">RECEIPT NUMBER</th>
                            <th class="text-center">AMOUNT</th>
                            <th class="text-center">CELLPHONE NO.</th>
                            <th class="text-center">EMAIL</th>
                 		</tr>
                    </thead >
         		    <tbody>
                        @if(count($_item_product_code) > 0)
         				@foreach($_item_product_code as $key => $item)
                        <tr>
             				<td class="text-center">{{$item->mlm_pin}}</td>
                            <td class="text-center">{{$item->mlm_activation}}</td>
                            <td class="text-center">{{$item->item_name}}</td>
                            <td class="text-center">{{date('m/d/Y', strtotime($item->record_log_date_updated))}}</td>
                            <td class="text-center">{{ucfirst($item->title_name." ".$item->first_name." ".$item->middle_name." ".$item->last_name." ".$item->suffix_name)}}</td>
                            <td class="text-center">{{$item->receipt_number}}</td>
                            <td class="text-center">{{ intval(preg_replace('/[^0-9]+/', '', $item->item_name), 10)}}</td>
                            <td class="text-center">{{$item->cellphone_number}}</td>
                            <td class="text-center">{{$item->email}}</td>       
                        </tr>
     				    @endforeach
                        @else
                        <tr>NO DATA FOUND</tr>
                        @endif
         		     </tbody>
         		</table>
         	</div>
          <h5 class="text-center">---- {{$now or ''}} ----</h5>
      </div>
  </div>
</div>