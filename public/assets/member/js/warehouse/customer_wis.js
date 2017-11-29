var customer_wis = new customer_wis()
var load_item = null;
var item_search_delay_timer;
var settings_delay_timer;
var keysearch = {};

function wis()
{
    init();

    function init()
    {
        $(document).ready(function()
        {
            document_ready();
        });
    }
    function document_ready()
    {

    }
}
function change_status(status)
{
    $('.customer-wis-container').load('/member/customer/wis/customer-load-wis-table?status='+status+' .customer-wis-table');
}
function success_confirm(data)
{
    if(data.status == 'success')
    {
        toastr.success('Success');
        setInterval(function()
        {
            location.reload();
        },2000);
    }
}
