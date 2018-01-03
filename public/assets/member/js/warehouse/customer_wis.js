var customer_wis = new customer_wis()

function customer_wis()
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
        location.reload();
    }
}