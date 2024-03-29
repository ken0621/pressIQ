var paginate_ajax = new paginate_ajax();
            
function paginate_ajax()
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
        event_run_paginate();
    }
    
    function event_run_paginate()
    {
        $('body').on('click', '.pagination a', function(e) 
        {

            e.preventDefault();
            
            var load_data = $(this).closest('.load-data');
            
            load_data.find('tr').css('opacity', '0.2');
            
            if (window.location.href.indexOf("https") != -1)
            {
                var url = $(this).attr('href').replace("http", "https");
            }
            else
            {
                var url = $(this).attr('href');
            }

            $url = $(e.currentTarget).attr("href");
            var url = new URL($url);
            $page = url.searchParams.get("page");

            $url = "/member/customer/list?page=" + $page;
            
            load_data.each(function() 
            {
                $.each(this.attributes, function() 
                {
                    if(this.specified && this.name != "class" && this.name != "style") 
                    {

                        url = url+"&&"+this.name+"="+this.value;
                        console.log(this.name, this.value);
                    }
                });
            });

            getArticles(url, load_data);
            // window.history.pushState("", "", url);
        });
    }

    function getArticles(url, load_data) {
        $.ajax(
        {
            url : url
        })
        .done( function(data)
        {
            load_data.hide().html(data).fadeIn();
            
            if (typeof loading_done == 'function')
            {
                loading_done_paginate();
            }
        })
        .fail( function() 
        {
            alert('Data could not be loaded.');
        });
    }
}