var theme_custom = new theme_custom();

function theme_custom()
{
    init();

    function init()
    {
        document_ready();

        $(window).load(function() 
        {
            window_load();
        });
    }
    
    function document_ready()
    {
        $(document).ready(function()
        {
            $window = $(window);
            $window.scroll(function() {
              $scroll_position = $window.scrollTop();
                if ($scroll_position > 32.2167) { 
                    $('.header-container').addClass('header-fixed');
                    $('.subheader-container').addClass('header-fixed');

                    header_height = $('.your-header').innerHeight();
                    $('body').css('padding-top' , header_height);
                } else {
                    $('body').css('padding-top' , '0');
                    $('.header-container').removeClass('header-fixed');
                    $('.subheader-container').removeClass('header-fixed');
                }
             });
        });
    }

    function window_load()
    {

    }
}