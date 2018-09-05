@section('content')
@extends('layout')
<div class="container-fluid">
   <div class="events">
      <div style="font-size: 4.2rem;
    line-height: 1.19;
    border-bottom: 0.1rem solid rgba(0,0,0,0.15);
    padding-bottom: 2rem;
    padding-top: 1.2rem;
    margin-bottom: 20px;
    font-weight: 300;">{{ $post->post_title }}</div>
      <table style="width: 100%; table-layout: fixed;">
         <tbody>
            <tr>
               <td class="main-event" style="overflow: auto;">
                  <div class="img">
                     <img src="{{ $post->post_image }}">
                  </div>
                  <div class="desc" id="wrap">
                     <iframe id="frame" scrolling="no" src="{{ URL::to('/events/view_description/' . $post->post_id)  }}" allowfullscreen="true" allowtransparency="true" onload="resizeIframe(this)"></iframe>
                  </div>
               </td>
               <td class="side-event">
                  @if(count($_related) > 1)
                  <?php $i = 0; ?>
                  @foreach($_related as $related)
                     @if($post->post_id != $related->post_id)
                        @if($i == 0)
                        <div class="holder first" onClick="location.href='/events/view/{{ $related->main_id }}'" style="cursor: pointer;">
                           <div class="img">
                              <img class="cova" src="{{ $related->post_image }}">
                           </div>
                           <div class="side-content">{{ $related->post_title }}</div>
                        </div>
                        @else
                        <table class="holder" onClick="location.href='/events/view/{{ $related->main_id }}'" style="cursor: pointer;">
                           <tbody>
                              <tr>
                                 <td class="img">
                                    <img style="height: 75px; width: 100%; object-fit: cover;" src="{{ $related->post_image }}">
                                 </td>
                                 <td class="side-content">{{ $related->post_title }}</td>
                              </tr>
                           </tbody>
                        </table>
                        @endif
                        <?php $i++; ?>
                     @endif
                  @endforeach
                  @else
                  <div class="holder text-center">No related Events</div>
                  @endif
               </td>
            </tr>
            <tr>
               <td class="text-center" colspan="2">
                  <button type="button" onClick="location.href='/events'" class="btn back">&laquo; Go Back</button>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/events-view.css?version=1">
<style type="text/css">
@media screen and (max-width: 991px)
{
   table tbody, table tr
   {
      display: block;
   }
}
.cova
{
   object-fit: cover !important;
   max-width: 100%;
}

iframe {
  display: block;
  width: 100%;
  /*border: 1px solid #666;*/
  border: 0;
  overflow-y: hidden;
  box-sizing: border-box;
  transform-origin: center top;
  transition: transform .05s linear;
  backface-visibility: hidden;
}
</style>
@endsection
@section('script')
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="resources/assets/frontend/js/events.js"></script>
<script type="text/javascript">
$('#wrap').hide();
function resizeIframe(obj) {
   $('#wrap').show();
   var _wrapWidth=$('#wrap').width();
   var _frameWidth=$($('#frame')[0].contentDocument).width();

   if(!this.contentLoaded)
   this.initialWidth=_frameWidth;
   this.contentLoaded=true;
   var frame=$('#frame')[0];

   var percent=_wrapWidth/this.initialWidth;

   frame.style.width=100.0/percent+"%";
   frame.style.height=100.0/percent+"%";

   frame.style.zoom=percent;
   frame.style.webkitTransform='scale('+percent+')';
   frame.style.webkitTransformOrigin='top left';
   frame.style.MozTransform='scale('+percent+')';
   frame.style.MozTransformOrigin='top left';
   frame.style.oTransform='scale('+percent+')';
   frame.style.oTransformOrigin='top left';

   obj.style.height = (obj.contentWindow.document.body.scrollHeight / percent) + 'px';
}
</script>
@endsection