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

$('.slider3').diyslider({
    width: "580px", // width of the slider
    height: "120px", // height of the slider
    display: 5, // number of slides you want it to display at once
    loop: false // disable looping on slides
    }); // this is all you need!

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

// NAVIRINO CLICK TOGGLE
$(".menu-nav").click(function()
{
    $(".navirino").toggle("slow");
});

/*PRODUCT HOVER TOGGLE*/
$('.product-hover').hover(function()
{
    $('.product-dropdown').stop();
    $('.product-dropdown').fadeIn(400);
},
function()
{
    $('.product-dropdown').stop();
    $('.product-dropdown').fadeOut(400);
});

$('.company-hover').hover(function()
{
    $('.company-dropdown').stop();
    $('.company-dropdown').fadeIn(400);
},
function()
{
    $('.company-dropdown').stop();
    $('.company-dropdown').fadeOut(400);
});

$('.cart-hover').hover(function()
{
    $('.cart-dropdown').stop();
    $('.cart-dropdown').fadeIn(400);
},
function()
{
    $('.cart-dropdown').stop();
    $('.cart-dropdown').fadeOut(400);
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