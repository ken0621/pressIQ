function submit_done(data)
{
	if(data.status == "success")
    {
        toastr.success("Success");
        $(".email-content-container").load("/member/maintenance/email_content .email-content-container"); 
        $(data.target).html(data.view);
        $('#global_modal').modal('toggle');
        $("#all-list").addClass("active");
        $("#archived-list").removeClass("active");
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