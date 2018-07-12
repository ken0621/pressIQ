<div class="report-container">
  <div class="panel panel-default panel-block panel-title-block panel-report load-data">
      <div class="panel-heading load-content">
         @include('member.reports.report_header');
         <div class="table-reponsive">
         		<table class="table table-condensed collaptable">
                    <thead >
                 		<tr>
                            <th class="text-center">PIN</th>
                 			<th class="text-center">ACTIVATION</th>
                 			<th class="text-center">ITEM NAME</th>
                            <th class="text-center">DATE UPDATED</th>
                 		</tr>
                    </thead >
         		    <tbody>
         				@foreach($_item_product_code as $key => $item)
                        <tr>
             				<td class="text-center">{{$item->mlm_pin}}</td>
                            <td class="text-center">{{$item->mlm_activation}}</td>
                            <td class="text-center">{{$item->item_name}}</td>
                            <td class="text-center">{{date('m/d/Y', strtotime($item->record_log_date_updated))}}</td>
                 		</tr>
     				   @endforeach
         		 </tbody>
         		</table>
         	</div>
          <h5 class="text-center">---- {{$now or ''}} ----</h5>
      </div>
  </div>
</div>