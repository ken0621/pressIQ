var theme_custom = new theme_custom()

function theme_custom()
{
    init();
    function init()
    {
        document_ready();
    }
    function document_ready()
    {
        $(document).ready(function()
        {
            $window = $(window);
            $window.scroll(function() 
            {
              $scroll_position = $window.scrollTop();
                if ($scroll_position > 32.2167) { 
                    $('.header-container').addClass('header-fixed');
                    $('.subheader-container').addClass('header-fixed');

                    header_height = $('.your-header').innerHeight();
                    $('body').css('padding-top' , header_height);
                } 
                else 
                {
                    $('body').css('padding-top' , '0');
                    $('.header-container').removeClass('header-fixed');
                    $('.subheader-container').removeClass('header-fixed');
                }
             });

            // use buttons to change slide
            $('#gotoleft').bind("click", function(){
                // Go to the previous slide
                $('.slider3').diyslider("move", "back");
            });
            $('#gotoright').unbind("click")
            $('#gotoright').bind("click", function(){
                // Go to the previous slide
                $('.slider3').diyslider("move", "forth");
            });

            /*MOBILE SIDE NAV*/
            $menuLeft = $('.pushmenu-left');
            $nav_list = $('#nav_list');

            $nav_list.click(function() {
                $(this).toggleClass('active');
                // $('.pushmenu-push').toggleClass('pushmenu-push-toright');
                $menuLeft.toggleClass('pushmenu-open');
            });

            // NAVIRINO CLICK TOGGLE
            $(".menu-nav").click(function()
            {
                $(".navirino").toggle("slow");
            });

            /*scroll up*/
            $(window).scroll(function () {
                if ($(this).scrollTop() > 700) {
                    $('.scroll-up').fadeIn();
                } else {
                    $('.scroll-up').fadeOut();
                }
            });

            $('.scroll-up').click(function () {
                $("html, body").animate({
                    scrollTop: 0
                }, 700);
                return false;
            });

            /*EXIT SIDE NAV TOGGLE*/
            $('.nav-ext').click(function()
            {
                $('#overlay').click();
            });
        });
    }
}

function on() 
{
    document.getElementById("overlay").style.display = "block";
    $("body").css({"overflow": "hidden","position": "fixed","margin": "0","padding": "0","right": "0","left": "0"});
    $(".blur-me").css({
        filter: 'blur(20px)'
    });
}

function off()
{
    document.getElementById("overlay").style.display = "none";
    $('.pushmenu').removeClass("pushmenu-open");
    $("body").css({"overflow": "auto","position": "static"});
    $(".blur-me").css({
        filter: 'blur(0)'
    });
}