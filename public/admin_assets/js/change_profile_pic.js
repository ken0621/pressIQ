 var ajaxdata = {};
    $("body").on("click", ".save_pic", function(e)
    {
      /*$url = $('.profile_image').attr("src"); //get URL (string)
      var url = new URL($url); //convert format URL
      action_load_table($url);
      $.ajax({
        type: "POST",
        url: "/admin/profile_picture_update",
        data: $('.upload_pic_form').serialize(),
        success: function(data){
          alert('123');
        },
        error: function(data){
          alert('error');
        }
      });
      */

      
        $(".upload_pic_form").ajaxSubmit({
          success: function(data)
          {

            if(data.status == 'success')
            {
            var fixed_url = "/uploads/Digima-17/";
            var url = $(location).attr('href');
            $(".profile_image").attr("src",fixed_url+data.message);
            $(".profile_image").attr("src",fixed_url+data.message);
            $(".profile_image").attr("src",fixed_url+data.message);
            $(".profile_image").attr("src",fixed_url+data.message);
            }
            else
            {
              console.log(data);
              alert(data.message);
            }
          }
        }); 
        return false;

/*
          var formData = new FormData($(".upload_pic_form"));

          $.ajax({
              url: "/admin/profile_picture_update",
              type: 'POST',
              data: formData,
              success: function (data) {
                  alert(data)
              },
              contentType: false,
              processData: false
          });

          return false;*/





    });