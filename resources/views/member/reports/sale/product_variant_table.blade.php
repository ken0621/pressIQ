@if($item)
    @foreach($item as $key => $prod)
    <tr>
        <td><a href="#">{{$prod['info']->product_name}}</a></td>
        <td><a href="#">{{$prod['variant']}}</a></td>
        <td>{{$prod['info']->variant_sku}}</td>
        <td class="text-center">{{$prod['quantity']}}</td>
        <td class="text-right">
            <span class="pull-left">PHP</span>{{currency('',$prod['gross'])}}</td>
        <td class="text-right">
            <span class="pull-left">PHP</span>{{currency('',$prod['discount'])}}</td>
        <td class="text-right">
            <span class="pull-left">PHP</span>{{currency('',$prod['net'])}}</td>
        <td class="text-right">
            <span class="pull-left">PHP</span>{{currency('',$prod['tax'])}}</td>
        <td class="text-right">
            <span class="pull-left">PHP</span>{{currency('',$prod['total'])}}</td>
    </tr>
    @endforeach
@else
    <h4 class="text-center">No Data Found!</h4>
@endif