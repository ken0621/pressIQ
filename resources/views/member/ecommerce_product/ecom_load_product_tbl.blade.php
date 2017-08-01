<div class="table-responsive">
    <table class="table table-hover table-bordered table-striped table-condensed">
        <thead id="thead_table_sort" link="/member/ecommerce/product/ecom_load_product_table">
            <tr>
                <!-- <td class="col-md-2"></td> -->
                <th class="text-center">
                    <a href="/member/ecommerce/product/list?filter={{$filter}}&column_name=eprod_id&in_order={{Request::input('column_name') == 'eprod_id' && Request::input('in_order') != 'asc' ? 'asc' : 'desc' }}">ID
                    @if(Request::input('column_name') == 'eprod_id' && Request::input('in_order') == 'asc')
                     <i class="fa fa-fw fa-sort-desc"></i>
                    @elseif(Request::input('column_name') == 'eprod_id' && Request::input('in_order') == 'desc')
                     <i class="fa fa-fw fa-sort-asc"></i>
                     @else
                     <i class="fa fa-fw fa-sort"></i>
                     @endif
                     </a>
                 </th>
                <th class="text-center">
                    <a href="/member/ecommerce/product/list?filter={{$filter}}&column_name=eprod_name&in_order={{Request::input('column_name') == 'eprod_name' && Request::input('in_order') != 'asc' ? 'asc' : 'desc' }}">Product
                    @if(Request::input('column_name') == 'eprod_name' && Request::input('in_order') == 'asc')
                     <i class="fa fa-fw fa-sort-desc"></i>
                    @elseif(Request::input('column_name') == 'eprod_name' && Request::input('in_order') == 'desc')
                     <i class="fa fa-fw fa-sort-asc"></i>
                     @else
                     <i class="fa fa-fw fa-sort"></i>
                     @endif
                     </a>
                </th>
                <th class="text-center">
                    <a href="/member/ecommerce/product/list?filter={{$filter}}&column_name=inventory_count&in_order={{Request::input('column_name') == 'inventory_count' && Request::input('in_order') != 'asc' ? 'asc' : 'desc' }}">Inventory
                    @if(Request::input('column_name') == 'inventory_count' && Request::input('in_order') == 'asc')
                     <i class="fa fa-fw fa-sort-desc"></i>
                    @elseif(Request::input('column_name') == 'inventory_count' && Request::input('in_order') == 'desc')
                     <i class="fa fa-fw fa-sort-asc"></i>
                     @else
                     <i class="fa fa-fw fa-sort"></i>
                     @endif
                     </a>
                </th>
                <th class="text-center">
                    <a href="/member/ecommerce/product/list?filter={{$filter}}&column_name=eprod_is_single&in_order={{Request::input('column_name') == 'eprod_is_single' && Request::input('in_order') != 'asc' ? 'asc' : 'desc' }}">Type
                    @if(Request::input('column_name') == 'eprod_is_single' && Request::input('in_order') == 'asc')
                     <i class="fa fa-fw fa-sort-desc"></i>
                    @elseif(Request::input('column_name') == 'eprod_is_single' && Request::input('in_order') == 'desc')
                     <i class="fa fa-fw fa-sort-asc"></i>
                     @else
                     <i class="fa fa-fw fa-sort"></i>
                     @endif
                     </a>
                </th>
                <th class="text-center">
                    <a href="/member/ecommerce/product/list?filter={{$filter}}&column_name=date_created&in_order={{Request::input('column_name') == 'date_created' && Request::input('in_order') != 'asc' ? 'asc' : 'desc' }}">Date Created
                    @if(Request::input('column_name') == 'date_created' && Request::input('in_order') == 'asc')
                     <i class="fa fa-fw fa-sort-desc"></i>
                    @elseif(Request::input('column_name') == 'date_created' && Request::input('in_order') == 'desc')
                     <i class="fa fa-fw fa-sort-asc"></i>
                     @else
                     <i class="fa fa-fw fa-sort"></i>
                     @endif
                     </a>
                </th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($_product as $product)
            <tr>
                <td class="text-center" >{{ $product->eprod_id }}</td>
                <td>{{ $product->eprod_name}}</td>
                <td class="text-center">{{ $product->inventory_count}}</td>
                <td class="text-center">{{ $product->eprod_is_single==1 ? 'single' : 'multi'  }}</td>
                <td class="text-center">{{ $product->date_created }}</td>
                <td class="text-center">
                    <!-- ACTION BUTTON -->
                    @if($filter == "active")
                        <div class="btn-group">
                            <a class="btn btn-primary btn-grp-primary" href="/member/ecommerce/product/edit/{{ $product['eprod_id'] }}" >Edit</a>
                            <a class="btn btn-primary btn-grp-primary popup" href="javascript:" link="/member/ecommerce/product/product-archive-restore/archive/{{ $product['eprod_id'] }}" size="md"><span class="fa fa-trash"></span></a>
                        </div>
                    @else
                        <div class="btn-group">
                            <a class="btn btn-primary btn-grp-primary popup" link="/member/ecommerce/product/product-archive-restore/restore/{{ $product['eprod_id'] }}" size="md">Restore</a>
                        </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="text-center pull-right">
    {!!$_product->render()!!}
</div>