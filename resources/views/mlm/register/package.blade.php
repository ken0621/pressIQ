@extends("mlm.register.layout")
@section("content")
<form method="post" class="register-submit" action="/member/register/package/submit" >
{!! csrf_field() !!}
<div class="package">
  <div class="container-fluid text-center">
    <div class="title">Create a Brown Package</div>
    <div class="sub">Aenea commodo ligula eget dolor.</div>
    <div class="membership">
      <div class="row clearfix">
      @if(count($membership) >= 1)
        @if(count($membership) == 1)
        <div class="col-md-4"></div>
        @endif
        @foreach($membership as $key => $value)
        <div class="col-md-4">
          <div class="holder">
            <div class="img">
              @if($package[$key]->first())
                 <?php $pack = $package[$key]->first(); ?>

                  @if($pack->membership_package_imgage != null)
                  <img style="object-fit: contain; height: 250px;" class="img_header_{{$value->membership_id}}" src="{{$pack->membership_package_imgage}}">
                  @else 
                  <img style="object-fit: contain; height: 250px;" class="img_header_{{$value->membership_id}}" src="/assets/mlm/img/placeholder.jpg">
                  @endif
              @else
                <img style="object-fit: contain; height: 250px;" class="img_header_{{$value->membership_id}}" src="/assets/mlm/img/placeholder.jpg">
              @endif
              
            </div>
            <div class="text-holder">
              <div class="name">
                <div class="radio">
                  <label><input type="radio" name="membership" value="{{$value->membership_id}}"> {{$value->membership_name}}</label>
                </div>
              </div>
              <!-- <div class="membership-name">Silver Membership</div> -->
              <div class="membership-price">{{currency('PHP', $value->membership_price)}}</div>
              <div class="info">Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.</div>
              <div class="type">
                <select class="form-control input-lg" name="package[{{$value->membership_id}}]" onChange="change_picture_a(this)">
                  @if($package[$key]->first())
                    @foreach($package[$key] as $key2 => $value2)
                    <option value="{{$value2->membership_package_id}}" membership_id="{{$value->membership_id}}" image="{{$value2->membership_package_imgage}}">{{$value2->membership_package_name}}</option>
                    @endforeach
                  @else
                    <option>NO PACKAGE AVAILABLE</option>
                  @endif
                </select>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      @else
        
      @endif  
      </div>
    </div>
    <div class="button-holder">
      <button class="btn btn-green btn-lg">PROCEED TO PAYMENT</button>
    </div>
  </div>
</div>
</form>
@endsection
@section('script')
<script type="text/javascript">
function change_picture_a(ito)
{
  var img = $(ito).find('option:selected').attr('image');
  var membership_id = $(ito).find('option:selected').attr('membership_id');
  console.log(img);
  $(".img_header_" + membership_id).attr("src", img);
}
  $(document).on("submit", ".register-submit", function(e)
        {
            var data = $(e.currentTarget).serialize();
            var link = $(e.currentTarget).attr("action");
            $('#load').removeClass('hide');
            submit_form_register(link, data);
            e.preventDefault();
            
        })
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
<link rel="stylesheet" type="text/css" href="/assets/mlm/css/register-package.css">
@endsection