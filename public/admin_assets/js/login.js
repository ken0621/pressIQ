var login = login()

function login()
{
  init();
}

  function init()
  {
    $(document).ready(function()
    {
      document_ready();
    });
  }

  function document_ready()
  {
    event_reload();
    event_click_login();
  }

  function event_reload(e)
  {
    $('form.login').submit(function(e)
    {
      e.preventDefault();

    });
  }

  function event_click_login()
  { 

  $('form.login').submit(function(e) 
    {

      var url = "/admin/login"; // the script where you handle the form input.
      var formData= $('form.login').serialize();
      $.ajax({
             type: "POST",
             url: url,
             data: formData,
             success: function(data)
             {
                if (data == "false") 
                {
                  alert('Invalid Username and Password');
                }
                else
                {
                  alert('login successfully');
                  window.location='/admin/profile'
                }
             }
        });
    });
  }

  $(document).ready(function()
  {
    $('.autoplay').slick(
    {
      slidesToShow: 4,
      slidesToScroll: 1,
      dots: false,
      autoplay: true,
      autoplaySpeed: 2000,
    });
  });

    var ajaxdata = {};
      $('.fa-spin').hide();
      $("body").on("click", ".pagination a", function(e)
      {
      $('.fa-spin').show();
      $url = $(e.currentTarget).attr("href"); //get URL (string)
      var url = new URL($url); //convert format URL
      $page = url.searchParams.get("page"); //get the page in the URL
      ajaxdata.page = $page;
      ajaxdata.page = 1;
      action_load_table($url);
      return false;
    });

  function action_load_table($url)
  {

  $(".info_table").load($url+" .info_table"); 
  $(".pagination-container").load($url+" .pagination-container", function()
    {
     $('.fa-spin').hide();
    }); 
  } 


  

  



