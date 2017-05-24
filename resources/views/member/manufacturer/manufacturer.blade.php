
<form class="global-submit form-to-submit-add" action="{{$action}}" method="post">
<style type="text/css">
    .chosen-container
    {
        width: 100% !important;
    }
</style>
<input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="manufacturer_id" value="{{$manufacturer->manufacturer_id or ''}}" >
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title layout-modallarge-title item_title">Manufacturer</h4>
</div>
<div class="modal-body modallarge-body-layout background-white form-horizontal menu_container">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-12">            
                <label>Manufacturer Name *</label>
                <input type="text" class="form-control" value="{{$manufacturer->manufacturer_name or ''}}" name="manufacturer_name" id="warehouse_name">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">   
                <label>Contact Person *</label>
            </div>
            <div class="col-md-4">            
                <input type="text" class="form-control" placeholder="First Name" value="{{$manufacturer->manufacturer_fname or ''}}" name="manufacturer_fname">
            </div>
            <div class="col-md-4">            
                <input type="text" class="form-control" placeholder="Middle Name" value="{{$manufacturer->manufacturer_mname or ''}}" name="manufacturer_mname">
            </div>
            <div class="col-md-4">            
                <input type="text" class="form-control" placeholder="Last Name" value="{{$manufacturer->manufacturer_lname or ''}}" name="manufacturer_lname">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">            
                <label>Manufacturer Address </label>
                <textarea type="text" class="form-control" name="manufacturer_address">{{$manufacturer->manufacturer_address or ''}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">            
                <label>Phone Number </label>
                <input type="text" class="form-control" value="{{$manufacturer->phone_number or ''}}" name="phone_number">
            </div>
        </div> 
        <div class="form-group">
            <div class="col-md-12">            
                <label>Email Address</label>
                <input type="text" class="form-control" value="{{$manufacturer->email_address or ''}}" name="email_address">
            </div>
        </div>         
        <div class="form-group">
            <div class="col-md-12">            
                <label>Website</label>
                <input type="text" class="form-control" value="{{$manufacturer->website or ''}}" name="website">
            </div>
        </div>
        @if(!isset($manufacturer))
        <div class="form-group">
            <div class="col-md-12">            
                <input type="checkbox" name="create_vendor" value="create_vendor"> <span>Create this Manufacturer as my Vendor</span>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="modal-footer" >
    <button type="button" class="btn btn-custom-white" data-dismiss="modal">Cancel</button>
    <button class="btn btn-custom-primary btn-save-modallarge" type="submit" data-url="">Save Manufacturer</button>
</div>
</form>

<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
<!-- <script type="text/javascript" src="/assets/member/js/truck.js"></script> -->
<!-- <script type="text/javascript" src="/assets/member/js/warehouse.js"></script> -->