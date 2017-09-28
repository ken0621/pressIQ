var globalv2 = new globalv2();
var jqxhr = {abort: function () {}};

function globalv2()
{
    this.call_event_cart = function() 
    {
        cart_event();
    }

    init();

    function init()
    {
        action_replace_brokenimg();
        
        $(document).ready(function()
        {
            document_ready();
        });

        $(window).load(function() 
        {
            window_load();
        });
    }
    function document_ready()
    {
        action_image_crop();
        match_height();
        event_sticky_nav();
        event_list_category();
        event_add_to_cart();
        action_quantity_cart();
    }
    function window_load()
    {
        if (typeof action_after_load == 'function') 
        {
            action_after_load();    
        }
    }
    function match_height()
    {
        $('.match-height').matchHeight();
    }
    function event_sticky_nav()
    {
        var stickyOffset = $('.main-content-scroll').offset().top;
        var nav_height = $('header').height();

        $(window).resize(function()
        {
            $("header").removeClass('hide'); 
            $('.sticky-nav').addClass('hide-sticky'); 
            $('.main-content-scroll').css("margin-top", "");

            stickyOffset = $('.main-content-scroll').offset().top;
            nav_height = $('header').height();
        });

        action_sticky_nav(stickyOffset, nav_height);

        $(window).bind("scroll", function()
        {
            action_sticky_nav(stickyOffset, nav_height);
        });
    }
    function action_sticky_nav(stickyOffset, nav_height)
    {
        var sticky = $('header'),
            scroll = $(window).scrollTop();

        if (scroll >= stickyOffset) 
        {
            sticky.addClass('hide'); 
            $('.sticky-nav').removeClass('hide-sticky'); 
            $('.main-content-scroll').css("margin-top", nav_height);
        }
        else 
        {
            sticky.removeClass('hide'); 
            $('.sticky-nav').addClass('hide-sticky'); 
            $('.main-content-scroll').css("margin-top", "");
        }
    }
    function event_list_category()
    {
        $('.list-category-button').unbind("click");
        $('.list-category-button').bind("click", function()
        {
            action_list_category();       
        });
    }
    function action_list_category()
    {
        $('.list-category').toggleClass('hide');
    }
    function event_add_to_cart()
    {
        $(".product-add-cart").unbind("click");
        $(".product-add-cart").bind("click", function(e)
        {
            action_add_to_cart(e.currentTarget);
        });
    }
    function action_add_to_cart(self)
    {
        $(self).prop("disabled", true).attr("disabled", "disabled").css("opacity", "0.5");

        var item_id = $(self).attr("item-id");
        var quantity = $(self).attr("quantity");

        $.ajax({
            url: '/cartv2/add',
            type: 'GET',
            dataType: 'json',
            data: 
            {
                item_id: item_id,
                quantity: quantity
            },
        })
        .done(function(data) 
        {
            if (data == "success") 
            {
                action_load_link_to_modal("/cartv2", "lg");
                $(self).removeProp("disabled").removeAttr("disabled").css("opacity", "1");
            }
            else
            {
                alert("Some error occurred. Please contact the administator.");
            }
        })
        .fail(function() 
        {
            console.log("error");
        })
        .always(function() 
        {
            console.log("complete");
        });
    }
    function action_quantity_cart()
    {
        $.ajax({
            url: '/cartv2/quantity',
            type: 'GET',
            dataType: 'json'
        })
        .done(function(quantity) 
        {
            $(".quantity-item-holder").text(quantity);
        })
        .fail(function() 
        {
            console.log("error");
        })
        .always(function() 
        {
            console.log("complete");
        });
    }
}

function number_format(number)
{
    var yourNumber = (number).toFixed(2);
    //Seperates the components of the number
    var n= yourNumber.toString().split(".");
    //Comma-fies the first part
    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //Combines the two sections
    return (n.join("."));
}

function image_crop(selector, width, height)
{
    $(selector).css("object-fit", "cover");
    $(selector).keepRatio({ ratio: width/height, calculate: 'height' });
}

function action_image_crop()
{
    image_crop(".1-1-ratio", 1, 1);
    image_crop(".4-3-ratio", 4, 3);
}

function action_replace_brokenimg()
{
    $("img").error(function () 
    {
      $(this).unbind("error").attr("src", "/assets/front/img/placeholder.png");
    });
}