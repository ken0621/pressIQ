<div class="table-responsive">
    <table class="table table-hover table-bordered table-striped table-condensed">
        <thead id="thead_table_sort" link="/member/ecommerce/product/ecom_load_product_table">
            <tr>
                <!-- <td class="col-md-2"></td> -->
                <th class="text-center">ID
                 <i class="fa fa-fw fa-sort hidden" onclick="sort_table('eprod_id','asc')"></i><i class="fa fa-fw fa-sort-asc hidden" onclick="sort_table('eprod_id','asc')"></i><i class="fa fa-fw fa-sort-desc hidden" onclick="sort_table('eprod_id','desc')"></i>
                 </th>
                <th class="text-center">Product</th>
                <th class="text-center">Inventory</th>
                <th class="text-center">Type</th>
                <th class="text-center">Date Created</th>
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