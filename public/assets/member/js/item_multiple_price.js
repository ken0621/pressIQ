var item_multiple_price = new item_multiple_price();
var global_tr_price_html = $(".div-script table.div-script-row-price tbody").html();

function item_multiple_price()
{
	init();

	function init()
    {
        event_remove_tr();
        event_add_tr();
        console.log("hello1");
    }

    function event_remove_tr()
    {
        $(document).on("click", ".remove-tr-price", function(e){
            if($(".tbody-item-price .remove-tr-price").length > 1){
                $(this).parent().remove();
            }           
        });
    }

    function event_add_tr()
    {
        $(document).on("click", ".add-tr-price ", function(e){
            $("tbody.tbody-item-price").append(global_tr_price_html);
        });
    }
}