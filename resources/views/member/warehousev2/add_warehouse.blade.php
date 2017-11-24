
<form class="global-submit form-to-submit-add" action="/member/item/v2/warehouse/add-submit" method="post">
<style type="text/css">
    .chosen-container
    {
        width: 100% !important;
    }
</style>
<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title layout-modallarge-title item_title">Add Warehouse</h4>
</div>
<div class="modal-body modallarge-body-layout background-white form-horizontal menu_container">
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-6">            
                <label>Warehouse Name *</label>
                <input type="text" required class="form-control" name="warehouse_name" id="warehouse_name">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">            
                <label>Warehouse Address *</label>
                <textarea required class="form-control input-sm" name="warehouse_address" id="warehouse_address"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer" >
    <button type="button" class="btn btn-custom-white" data-dismiss="modal">Cancel</button>
    <button class="btn btn-custom-primary btn-save-modallarge" type="submit" data-url="">Save Warehouse</button>
</div>
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
<!-- <script type="text/javascript" src="/assets/member/js/draggable_row.js"></script> -->
<!-- <script type="text/javascript" src="/assets/member/js/transfer_warehouse.js"></script> -->
<script type="text/javascript" src="/assets/member/js/warehouse.js"></script>
<script type="text/javascript">

    check_checkbox();
    checkbox_change();

    function submit_selected_image_done(data) 
    { 
        $(".merchant_logo_container").attr("src",data.image_data[0].image_path);
        $(".merchant_logo_input").val(data.image_data[0].image_path);
    }

    function check_checkbox()
    {
        if($("#merchantwarehouse").prop("checked"))
        {
            $(".merchant_logo_div").show();
            $(".default_repurchase_class").show();
        }
        else
        {
            $(".merchant_logo_div").hide();
            $(".default_repurchase_class").hide();
        }   
    }

    function checkbox_change()
    {
        $("input[type=checkbox]").change(function()
        {
            check_checkbox();
        });
    }
</script>