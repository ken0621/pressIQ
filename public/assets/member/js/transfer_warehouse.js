function submit_done(data)
{
    if(data.status == "success")
    {
        toastr.success("Success");
        $(".warehouse-container").load("/member/item/warehouse .warehouse-container"); 
        $(data.target).html(data.view);
        data.element.modal("hide");
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
    else if(data.status == "success-adding-serial")
    {
        toastr.success("Success");
        $(data.target).html(data.view);
        $(".warehouse-container").load("/member/item/warehouse .warehouse-container"); 
        data.element.modal("hide");
    }
    else if(data.status == "confirmed-serial")
    {
        prompt_serial_number();
    }
    else if(data.status == "Sucess-archived")
    {
        toastr.success("Successfully archived");
        $(".warehouse-container").load("/member/item/warehouse .warehouse-container"); 
        $(data.target).html(data.view);
        data.element.modal("hide");       
    }
    else if(data.status == "Sucess-restore")
    {
        toastr.success("Successfully Restore");
        $(".warehouse-container").load("/member/item/warehouse .warehouse-container");
        $("#all-list").addClass("active");
        $("#archived-list").removeClass("active");
        $(data.target).html(data.view);
        data.element.modal("hide");     
    }
    else
    {
        $(data.error).each(function( index )
        {
          toastr.warning(data.error[index]);
        });
    }
}
function submit_done_for_page(data)
{
    if(data.status == "transfer_success")
    {
        location.href = "/member/item/warehouse"; 
        toastr.success("Successfully transfer");
        $(data.target).html(data.view);    
    }
    else if(data.status == "success")
    {
        toastr.success("Success");
        $(".warehouse-container").load("/member/item/warehouse .warehouse-container"); 
        $(data.target).html(data.view);
        data.element.modal("hide");
    }
    else if(data.status == "success-serial")
    {
        toastr.success("Success");
        $(data.target).html(data.view);
        
        prompt_confirm();
    }
    else if(data.status == "success-adding-serial")
    {
        toastr.success("Success");
        $(".warehouse-container").load("/member/item/warehouse .warehouse-container"); 
        // $('#global_modal').modal('toggle');
        // $('.multiple_global_modal').modal('hide');

        data.element.modal("hide");
    }
    else if(data.status == "confirmed-serial")
    {
        prompt_serial_number();
    }
    else if(data.status == "error")
    {
        toastr.warning(data.status_message);
        $(data.target).html(data.view);
    }
    else
    {
        $(data.error).each(function( index )
        {
          toastr.warning(data.error[index]);
        });
    }
}