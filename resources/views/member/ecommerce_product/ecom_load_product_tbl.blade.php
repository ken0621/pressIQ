<div class="table-responsive">
    <table class="table table-hover table-bordered table-striped table-condensed">
        <thead>
            <tr>
                <!-- <td class="col-md-2"></td> -->
                <th class="col-md-1">ID</th>
                <th class="col-md-3">Product</th>
                <th class="col-md-2">Inventory</th>
                <th class="col-md-1">Type</th>
                <th class="col-md-3">Date Created</th>
                <th class="col-md-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($_product as $product)
            <tr>
                <!-- <td><img src="" style="width:50px"></td> -->
                <td>{{ $product->eprod_id }}</td>
                <td>{{$product->eprod_name}}</td>
                <td></td>
                <td>{{ $product->eprod_is_single==1 ? 'single' : 'multi'  }}</td>
                <td>{{ $product->date_created }}</td>
                <td>
                    <!-- ACTION BUTTON -->
                    @if($filter == "active")
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-custom-white  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a href="/member/ecommerce/product/edit/{{ $product["eprod_id"] }}">Edit product info</a></li>
                            </ul>
                        </div>
                    @else
                        <a href="javascript:">Restore</a>
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