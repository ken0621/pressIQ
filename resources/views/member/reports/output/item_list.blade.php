<div class="report-container">
  <div class="panel panel-default panel-block panel-title-block panel-report load-data">
      <div class="panel-heading load-content">
         @include('member.reports.report_header');
         <div class="table-reponsive">
         		<table class="table table-condensed collaptable">
            <tr>
              <th>Item/Service</th>
              <th>Type</th>
              <th>Description</th>
              <th>Price</th>
              <th>Cost</th>
              <th class="text-center" colspan="20">Qty On Hand</th>
            </tr>
            <tr>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              @foreach($_warehouse as $key=>$warehouse)
                <th>{{$warehouse->warehouse_name}}</th>
              @endforeach
              <th>Total</th>
            </tr>
         		<tbody>
         			
     				@foreach($_item as $key=>$item)
       				<tr>
                <td nowrap>{{$item->item_name}}</td>
                <td nowrap>{{$item->item_type_name}}</td>
                <td nowrap>{{$item->item_sales_information}}</td>
                <td class="text-right" nowrap>{{currency('',$item->item_price)}}</td>
                <td class="text-right" nowrap>{{currency('',$item->item_cost)}}</td>
                @foreach($item->item_warehouse as $key=>$item_wh)
                  <td class="text-center">{{$item_wh->qty_on_hand}}</td>
                @endforeach
                @if(count($item->item_warehouse))
                  <td class="text-center" nowrap>{{collect($item->item_warehouse)->sum('qty_on_hand')}}</td>
                @endif
              </tr>
     				@endforeach
         		</tbody>
         		</table>
         	</div>
          <h5 class="text-center">---- {{$now or ''}} ----</h5>
      </div>
  </div>
</div>