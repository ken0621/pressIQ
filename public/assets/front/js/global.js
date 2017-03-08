var global = new global();

function global()
{
    init();
    function init()
    {
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
        $('.loader').fadeOut();
    }
    function window_load()
    {
        image_crop(".4-3-ratio", 4, 3);
        image_crop(".ratio-fix img", 396, 241);
        image_crop(".category-ratio img", 500, 342.5);
        image_crop(".brand img", 200, 125);
    }
}

function image_crop(selector, width, height)
{
    $(selector).css("object-fit", "cover");
    $(selector).keepRatio({ ratio: width/height, calculate: 'height' });
}