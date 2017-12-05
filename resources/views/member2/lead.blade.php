<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4 class="modal-title">COPY LEAD LINK BELOW</h4>
</div>
<div class="modal-body clearfix">
  <div class="clearfix">
    <input class="leadlink form-control pull-left" style="width: calc(100% - 200px)" type="text" value="{{ $url }}/{{ urlencode(request('slot_no')) }}"/>
    <button onclick="return ClipBoard()" class="pull-right btn btn-primary lead-big-button" style="width: 190px;">COPY LINK</button>
  </div>
  <div class="clearfix" style="margin-top: 10px;">
    <h3 class="text-center">Share our products</h3>
    <div class="row clearfix">
        @foreach($_product as $key => $product)
            <div class="col-md-4 col-sm-6">
                <div class="product-holder" style="margin-top: 10px;">
                    <div class="img">
                        <img class="4-3-ratio" style="width: 100%;" src="{{ get_product_first_image($product) }}" alt="">
                    </div>
                    <div class="name" style="text-align: center; font-size: 14px; font-weight: 500; margin-bottom: 2.5px;">Product {{ $product["eprod_name"] }}</div>
                    <div class="link"><input value="{{ $url }}/{{ urlencode(request('slot_no')) }}/{{ $product['eprod_id'] }}" class="form-control input-sm link-{{ $key }}" type="text"></div>
                    <div style="margin-top: 7.5px;"><button onClick="copyToClipboard($('.link-{{ $key }}'))" class="btn btn-sm lead-small-button btn-primary" style="width: 100%;">COPY LINK</button></div>
                </div>
            </div>
        @endforeach
    </div>
  </div>
</div>

<script type="text/javascript">
action_image_crop();

function ClipBoard()
{
   copyToClipboard(".leadlink");
}

function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).val()).select();
  document.execCommand("copy");
  $temp.remove();
}


</script>