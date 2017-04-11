<div class="table-responsive">
    <table class="table table-hover table-bordered table-striped table-condensed">
        <thead>
            <tr>
                <!-- <td class="col-md-2"></td> -->
                <th class="text-center">ID</th>
                <th class="text-center">Coupon Code</th>
                <th class="text-center">Discount</th>
                <th class="text-center">Discount Type</th>
                <th class="text-center">Date Created</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($_coupon as $coupon)
            <tr>
                <td class="text-center">{{ $coupon->id_per_coupon }}</td>
                <td class="text-center">{{ $coupon->coupon_code}}</td>
                <td class="text-center">{{ $coupon->coupon_code_amount}}</td>
                <td class="text-center">{{ $coupon->coupon_discounted}}</td>
                <td class="text-center">{{ $coupon->date_created }}</td>
                <td class="text-center">
                    <!-- ACTION BUTTON -->
                    @if($filter == "unused")
                        <div class="btn-group">
                            <a class="btn btn-primary btn-grp-primary" href="" >Edit</a>
                            <a class="btn btn-primary btn-grp-primary popup" href="javascript:" link="" size="md"><span class="fa fa-trash"></span></a>
                        </div>
                    @else
                        <div class="btn-group">
                            <a class="btn btn-primary btn-grp-primary popup" link="" size="md">Restore</a>
                        </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="text-center pull-right">
    {!!$_coupon->render()!!}
</div>