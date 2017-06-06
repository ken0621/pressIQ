@extends("mlm.register.layout")
@section("content")
<form method="post" class="register-submit" action="/member/register/package/submit" >
{!! csrf_field() !!}
<div class="package">
  <div class="container-fluid text-center">
    <div class="title">Create a Brown Package</div>
    <div class="sub"></div>
    <div class="membership">
      <div class="row clearfix">
        @if(count($_product) > 0)
          @foreach($_product as $key => $value)
            <div class="col-md-4">
              <div class="holder">
                <div class="img">
                 @if($value->eprod_detail_image != null)
                  <img style="object-fit: contain; height: 250px;" class="img_header_{{$value->eprod_id}}" src="{{$value->eprod_detail_image}}">
                  @else 
                  <img style="object-fit: contain; height: 250px;" class="img_header_{{$value->eprod_id}}" src="/assets/mlm/img/placeholder.jpg">
                  @endif
                </div>
                <div class="text-holder">
                  <div class="name">
                    <div class="radio">
                      <label><input type="radio" name="variant_id" value="{{$value->evariant_id}}"> {{$value->eprod_name}}</label>
                    </div>
                  </div>
                  <div class="membership-price">{{currency('PHP', $value->min_price)}}</div>
                  <div class="info">
                    {!! $value->inventory_count <= 0 ? "<span style='color: red'>Out of Stock</span>" : "Current Stocks : " . number_format($value->inventory_count) !!}
                    <input type="hidden" name="product_stocks[{{$value->evariant_id}}]" value="{{$value->inventory_count}}">
                  </div>                  
                </div>
              </div>              
            </div>
          @endforeach
        @else
        <div class="text-center">
          No Product Available
        </div>        
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