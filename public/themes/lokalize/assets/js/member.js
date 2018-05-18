// Domain
var domain = "http://loyalty-system.test";

var myApp = new Framework7(
{
    modalTitle: 'Framework7',
    animateNavBackIcon: true,
});

// Expose Internal DOM library
var $$ = Dom7;

// Add main view
var mainView = myApp.addView('.view-main',
{
    dynamicNavbar: true,
});

var rightView = myApp.addView('.view-right',
{
    dynamicNavbar: true,
    name: 'right'
});

// Show/hide preloader for remote ajax loaded pages
// Probably should be removed on a production/local app
$$(document).on('ajaxStart', function (e)
{
    if (e.detail.xhr.requestUrl.indexOf('autocomplete-languages.json') >= 0)
    {
        // Don't show preloader for autocomplete demo requests
        return;
    }

    myApp.showIndicator();
});

$$(document).on('ajaxComplete', function (e)
{
    if (e.detail.xhr.requestUrl.indexOf('autocomplete-languages.json') >= 0)
    {
        // Don't show preloader for autocomplete demo requests
        return;
    }

    myApp.hideIndicator();
});


/* INTIIAL CODES */
initialize(); //initialize.js

myApp.onPageInit('index', function (page)
{
});

myApp.onPageInit('*', function (page)
{
    updateBalanceLabels();
});

myApp.onPageInit('exchange_buy', function (page)
{
    exchange_buy.initialize();
});

myApp.onPageInit('btc_deposit', function (page)
{
    $(".copy-address-to-clipboard").click(function()
    {
        var clipboard = $(".btc-address-text").text();

        myApp.addNotification({
            title: 'Successfully Copied',
            message: "<b>" +clipboard + "</b> has been successfully copied to clipboard."
        });

        copy(clipboard);

    });
});
