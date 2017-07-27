@extends("mlm.register.layout")
@section("content")
<form method="post" class="register-submit" action="/member/register/shipping/submit" >
    {!! csrf_field() !!}
<div class="payment">
  <div class="container-fluid">
    <div class="title">Getting Details</div>
    <div class="sub">Aenea commodo ligula eget dolor.</div>
    <div class="information-container">
      <div class="information-title">Delivery Information</div>
      <div class="form-holder">
        <div class="row clearfix">
          <div class="col-md-6">
            <div class="form-group">
              <label>First Name</label>
              <input type="text" class="form-control input-lg" name="first_name">
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" class="form-control input-lg" name="last_name">
            </div>
            <div class="form-group">
              <label>Contact Information</label>
              <input type="text" class="form-control input-lg" name="contact_info">
            </div>
            <div class="form-group">
              <label>Other Contact Information</label>
              <input type="text" class="form-control input-lg" name="contact_other">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Shipping Method</label>
              <select class="form-control input-lg">
                <option></option>
              </select>
            </div>
            <div class="form-group">
              <label>Complete Shipping Address</label>
              <textarea class="form-control input-lg" name="shipping_address"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="button-holder">
      <button class="btn btn-green btn-lg">PROCEED</button>
    </div>
  </div>
</div>
</form>
@endsection
@section('script')
<link rel="stylesheet" type="text/css" href="/assets/mlm/css/register-payment.css">
<script type="text/javascript">
  $(document).on("submit", ".register-submit", function(e)
        {
            var data = $(e.currentTarget).serialize();
            var link = $(e.currentTarget).attr("action");
            $('#load').removeClass('hide');
            submit_form_register(link, data);
            e.preventDefault();
            
        });

  function submit_form_register(link, data)
    {
        
        $.ajax({
            url:link,
            dataType:"json",
            data:data,
            type:"post",
            success: function(data)
            {
              $('#load').addClass('hide');
              if(data.status == 'warning')
              {
                var message = data.message;
                $.each( message, function( index, value ){
              toastr.warning(value);
          });
              }
              else if(data.status == 'success')
              {
                window.location = data.link;                
              }
            },
            error: function()
            {
                $('#load').addClass('hide');
            }
        })
    }
</script>
@endsection
@section("css")

@endsection