var item = new item();
var account_selected = ''; 
var item_selected; 
var item_type = null;
var global_tr_html = $(".div-script tbody").html();

function item()
{
    init();

    function init()
    {
        initialize_select();
        saved_input();
        $(".datepicker").datepicker();
        
        // event_accept_number_only();
        event_item_type_click();
        event_back_menu_click();
        event_image_change();

        /* For Multiple Table */
        event_remove_tr();
        event_add_tr();

        var option = $('option:selected', $(".measure_container")).attr('abbrev');
        $(".abbreviation").text(option);
    }

    function event_accept_number_only()
    {
        $(document).on("keypress",".number-input", function(event){
            if(event.which < 46 || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if(event.which == 46 && $(this).val().indexOf('.') != -1) {
                event.preventDefault();
            } // prevent if already dot

        });

        $(document).on("change",".number-input", function(){
            $(this).val(function(index, value) {         
                var ret = '';
                value = action_return_to_number(value);
                if(!$(this).hasClass("txt-qty")){
                    value = parseFloat(value);
                    value = value.toFixed(2);
                }
                if(value != '' && !isNaN(value)){
                    value = parseFloat(value);
                    ret = action_add_comma(value).toLocaleString();
                }
                
                if(ret == 0){
                    ret = '';
                }

                return ret;
              });
        });
    }
    function action_add_comma(number)
    {
        number += '';
        if(number == '0' || number == ''){
            return '';
        }

        else{
            return number.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    }
    function action_return_to_number(number = '')
    {
        number += '';
        number = number.replace(/,/g, "");
        if(number == "" || number == null || isNaN(number)){
            number = 0;
        }
        
        return parseFloat(number);
    }

    function initialize_select()
    {
        $(".drop-down-category").globalDropList(
        {
            width       : '100%',
            link        : '/member/item/category/modal_create_category',
            link_size   : 'md'
        });
        $(".drop-down-manufacturer").globalDropList(
        {
            width       : '100%',
            link        : '/member/item/manufacturer/add',
            link_size   : 'md'
        });
        $('.drop-down-vendor').globalDropList(
        { 
            width : "100%",
            link : "/member/vendor/add"
        });

        $(".drop-down-um").globalDropList(
        {
            width       : '100%',
            link        : '/member/item/unit_of_measurement/add',
            link_size   : 'lg',
            onChangeValue : function()
            {
                var id = $(this).val();
                $.ajax({
                    url : "/member/item/um/",
                    type : "get",
                    data : { id:id },
                    success : function(data)
                    {      
                        data = $.parseJSON(data);                                          
                        if(data.status == "pop-up-um")
                        {
                            console.log(data.status);
                            action_load_link_to_modal(data.action,"md");
                        }
                    }
                });
            }
        });

        $(".drop-down-coa").globalDropList(
        {
            width       : '100%',
            link        : '/member/accounting/chart_of_account/popup/add',
            link_size   : 'md',
            placeholder : 'Chart of Account',
            onCreateNew : function()
            {
                account_selected = $(this);
            }
        });

        action_select_plugin_item(".drop-down-item")
        action_select_plugin_um(".drop-down-um")
    }

    function action_select_plugin_item($this)
    {
        $($this).globalDropList(
        {
            link        : '/member/item/add',
            link_size   : 'lg',
            hasPopup    : 'false',
            width       : "100%",
            maxHeight   : "309px",
            placeholder : 'Item',
            onCreateNew : function()
            {
                item_selected = $(this);
            }
        });
    }

    function action_select_plugin_um($this)
    {
        $($this).globalDropList(
        {
            width       : '100%',
            hasPopup    : "false",
            placeholder : 'Unit of Measurement',
            onChangeValue : function()
            {
                var option = $('option:selected', this).attr('abbrev');
                $(".abbreviation").text(option);
            }
        });
    }

    function event_back_menu_click()
    {
        $(".back_to_menu").click(function()
        {
           $(".item_title").text("Item Type");
           back_to_menu();
        });
    }

    function back_to_menu()
    {
         $(".menu_container").slideDown();
         $(".inventory_type").slideUp();
         $(".noninventory_type").slideUp();
         $(".service_type").slideUp();
         $(".bundle_type").slideUp();
    }

    function event_item_type_click()
    {
        action_event_click_type("inventory_type", "Inventory");
        action_event_click_type("noninventory_type", "Non-Inventory");
        action_event_click_type("service_type", "Service");
        action_event_click_type("bundle_type", "Bundle");
    }

    function action_event_click_type(name, display)
    {
        $(document).on("click", "#"+name, function()
        {   
            item_type =$("#item_type_container").val();
            if(item_type != name)
            {
                $("#item_type_container").val(name);
                $(".form_one").find("input[type=text], textarea,input[type=number]").val("");
            }
            $(".item_title").text(display);
            $(".menu_container").slideUp();
            $("."+name).slideDown();
            console.log(item_type);
        });
    }
   
    function saved_input()
    {
        $("form :input").change(function()
        {
             $.ajax(
             {
               type: "POST",
               url: "/member/item/insert_saved_data?type_of_item="+$(this).closest('form').attr("type_of_item"),
               data: $(this).closest('form').serialize(), // serializes the form's elements.
               success: function(data)
               {
                //   alert(data); // show response from the php script.
               }
             }); 
        });
    } 

    function event_image_change()
    {
        $("#img_upload").change(function()
        {
            readURL(this);
        });
    }

    function readURL(input)
    {
        if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img-src').attr('src', e.target.result);
        }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function event_remove_tr()
    {
        $(document).on("click", ".remove-tr", function(e){
            if($(".tbody-item .remove-tr").length > 1){
                $(this).parent().remove();
            }           
        });
    }

    function event_add_tr()
    {
        $(document).on("click", ".add-tr", function(e){
            $("tbody.tbody-item").append(global_tr_html);
            action_trigger_select_plugin();
        });
    }
    
    function action_trigger_select_plugin()
    {
        action_select_plugin_item(".tbody-item tr:last select.select-item");
        action_select_plugin_um(".tbody-item tr:last select.select-um");
    }

    function action_remain_only_one_add()
    {
        $(".tbody-item .add-tr:not(':last') i").remove();
    }
}

function submit_done(data)
{
    if(data.type == 'account')
    {
        // action_reload_account(data.id);   
        toastr.success("Success");
        $(".drop-down-coa").load("/member/accounting/load_coa", function()
        {                
             $(".drop-down-coa").globalDropList("reload"); 
             account_selected.val(data.id).change();              
        });
        data.element.modal("hide");
    }
    else if(data.type == "manufacturer")
    {
        toastr.success("Success");
        $(".drop-down-manufacturer").load("/member/item/manufacturer/load_manufacturer", function()
        {                
             $(".drop-down-manufacturer").globalDropList("reload"); 
             $(".drop-down-manufacturer").val(data.id).change();              
        });
        data.element.modal("hide");
    }
    else if(data.type == "base-um")
    {        
        data.element.modal("hide");
    }
    else if(data.type == "unit-measurement")
    {
        toastr.success("Success");
        $(".drop-down-um").load("/member/item/load_um", function()
        {                
             $(".drop-down-um").globalDropList("reload"); 
             $(".drop-down-um").val(data.id).change();              
        });
        data.element.modal("hide");
    }
    else if(data.type == "category")
    {
        toastr.success("Success");
        $(".drop-down-category").load("/member/item/load_category", function()
        {                
             $(".drop-down-category").globalDropList("reload");
             $(".drop-down-category").val(data.id).change();              
        });
        data.element.modal("hide");
        // $('.multiple_global_modal').modal('hide');
    }
    else if(data.type == "multiple_price")
    {
        console.log("hello");
        toastr.success(data.message);
        data.element.modal("hide");
    }
    else if(data.status == "success-adding-serial")
    {
        toastr.success("Success");
        $(data.target).html(data.view);
        $('#global_modal').modal('toggle');
        $('.multiple_global_modal').modal('hide');
        location.reload();
    }
    else if(data.status == "success" || data.message == "Success")
    {
        toastr.success("Success");
        $(".codes_container").load("/member/item .codes_container"); 
        $('#global_modal').modal('toggle');
        $('.multiple_global_modal').modal('hide');
    }
    else if(data.status == "error")
    {
        toastr.warning(data.status_message);
        $(data.target).html(data.view);
    }
    else if(data.status == "success-serial")
    {
        toastr.success("Success");
        $(data.target).html(data.view);
         prompt_confirm();
    }
    else if(data.status == "confirmed-serial")
    {
        prompt_serial_number();
    }
    else
    {
        $(data.error).each(function( index )
        {
          toastr.warning(data.error[index]);
        });
    }
}

function submit_selected_image_done(data) 
{ 
    var image_path = data.image_data[0].image_path;
    var key = data.akey;

    $('.img-src[key="'+key+'"]').attr('src', image_path);
    $('.image-value[key="'+key+'"]').val(image_path);
}