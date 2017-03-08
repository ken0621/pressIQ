<table class="table table-hover table-condensed table-bordered">
    <thead>
        <tr>
            <th class="text-left">Name</th>
            <th class="text-left">Phone</th>
            <th class="text-left">Email</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($_vendor as $vendor)
         <tr class="cursor-pointer" id="tr-vendor-{{$vendor->vendor_id_s}}">
            <td class="col-md-5 text-left">{{$vendor->vendor_title_name.' '.$vendor->vendor_first_name.' '.$vendor->vendor_middle_name.' '.$vendor->vendor_last_name.' '.$vendor->vendor_suffix_name}}</td>
            <td class="col-md-2 text-left">{{$vendor->ven_info_phone}}</td>
            <td class="col-md-3 text-left">{{$vendor->vendor_email}}</td>
            <td class="col-md-2 text-center">
                <!-- ACTION BUTTON -->
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-custom-white  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-custom">
                    <!-- <li><a href="/member/vendor/create_po">Create Purchase Order</a></li> -->
                    <!-- <li><a href="/member/vendor/estimate">Create Estimate</li> -->
                    <li><a href="javascript:" class="popup" link="/member/vendor/archived/{{$vendor->vendor_id}}/inactive" size="md">Make Inactive</a></li>
                    <!-- <li><a href="javascript:" data-html="inactive">Make Inactive</a></li> -->
                    <li><a href="javascript:" class="popup" link="/member/vendor/edit/{{$vendor->vendor_id}}" size="lg">Edit vendor Info</a></li>
                  </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="text-center pull-right">
    {!!$_vendor->render()!!}
</div>