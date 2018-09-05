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
                  <div class="desc">
                     <iframe src="{{ URL::to('/events/view_description/' . $post->post_id)  }}" allowfullscreen="true" allowtransparency="true" frameborder="0" scrolling="no" onload="resizeIframe(this)"></iframe>
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
  height: 500px;
  border: 0;
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
function resizeIframe(obj) {
 obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}
/**
 * Scaling <iframe>-elements.
 * 
 * Emanuel Kluge
 * twitter.com/Herschel_R
 */
(function (win, doc) {

  /** Below this point the scaling takes effect. */
  var BREAKPOINT = 2000;
  
  /**
   * The `window.resize`-callback gets throttled
   * to an interval of 30ms.
  */
  var THROTTLE = 30;
  
  /** Just the declaration. Definition comes later. */
  var IFRAME_HEIGHT;

  var iframe = doc.getElementsByTagName('iframe')[0],
      timestamp = 0;
  
  /** Defining the inital iframe-height. */
  IFRAME_HEIGHT = parseInt(getComputedStyle(iframe).height, 10);
  
  /**
   * Takes an object with CSS-transform-properties
   * and generates a cross-browser-ready style string.
   *
   * @param  {Object} obj
   * @return {String}
   */
  function transformStr(obj) {
    var obj = obj || {},
        val = '',
        j;
    for ( j in obj ) {
      val += j + '(' + obj[j] + ') ';
    }
    val += 'translateZ(0)';
    return '-webkit-transform: ' + val + '; ' +
            '-moz-transform: ' + val + '; ' +
            'transform: ' + val;
  }
  
  /**
   * Scaling the iframe if necessary.
   *
   * @return {Function}
   */
  function onResize() {
  
    var now = +new Date,
        winWidth = win.innerWidth,
        noResizing = winWidth > BREAKPOINT,
        scale,
        width,
        height,
        offsetLeft;
    
    if ( now - timestamp < THROTTLE || noResizing ) {
      /** Remove the style-attr if we're out of the "scaling-zone". */
      noResizing && iframe.hasAttribute('style') && iframe.removeAttribute('style');
      return onResize;
    }
    
    timestamp = now;
    
    /**
     * The required scaling; using `Math.pow` to get
     * a safely small enough value.
     */
    scale = Math.pow(winWidth / BREAKPOINT, 1.0);
    
    /**
     * To get the corresponding width that compensates
     * the shrinking and thus keeps the width of the
     * iframe consistent, we have to divide 100 by the
     * scale. This gives us the correct value in percent.
     */
    width = 100 / scale;
    
    /**
     * We're using the initial height and the compen-
     * sating width to compute the compensating height
     * in px.
     */
    height = IFRAME_HEIGHT / scale;
    
    /**
     * We have to correct the position of the iframe,
     * when changing its width.
     */
    offsetLeft = (width - 100) / 2;
    
    /** Setting the styles. */
    iframe.setAttribute('style', transformStr({
      scale: scale,
      translateX: '-' + offsetLeft + '%'
    }) + '; width: ' + width + '%; ' + 'height: ' + height + 'px');
    
    return onResize;
  
  }
  
  /** Listening to `window.resize`. */
  win.addEventListener('resize', onResize(), false);

})(window.self, document);
</script>
@endsection