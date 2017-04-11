@section('content')
@extends('layout')
<div class="events">
   <div class="container-fluid">
      <!-- <div class="events-title">Events</div> -->
      <div class="events-container">
         <div class="clearfix grid">
            <div class="grid-sizer"></div>
            <div class="gutter-sizer"></div>
            <div class="grid-item grid-item--width2">
               <div class="event-slider">
                  <div class="slider-holder">
                     <img style="width: 100%;" src="/uploads/intogadgets-2/syScijvUVUoxuTm.jpg">
                     <div class="shadow"></div>
                     <div class="title">Test</div>
                  </div>
                  <div class="slider-holder">
                     <img style="width: 100%;" src="/uploads/intogadgets-2/syScijvUVUoxuTm.jpg">
                     <div class="shadow"></div>
                     <div class="title">Test</div>
                  </div>
                  <div class="slider-holder">
                     <img style="width: 100%;" src="/uploads/intogadgets-2/syScijvUVUoxuTm.jpg">
                     <div class="shadow"></div>
                     <div class="title">Test</div>
                  </div>
               </div>
            </div>
            @if(count($_post) > 0)
               @foreach($_post as $key => $post)
               <div class="grid-item clearfix">
                  <div class="event-holder" onClick="location.href='/events/view/{{ $post->post_id }}'">
                     <div class="img">
                        <img class="4-3-ratio" style="width: 100%;" src="{{ $post->post_image }}">
                     </div>
                     <div class="text">
                        <div class="cat">
                           @if(count($post->categories) > 0)
                              @foreach($post->categories as $categories)
                                 <span>{{ $categories->post_category_name }}</span>
                              @endforeach
                           @endif
                        </div>
                        <div class="title">{{ $post->post_title }}</div>
                        <div class="desc">{{ $post->post_excerpt }}</div>
                     </div>
                  </div>
               </div>
               @endforeach
            @endif
         </div>
      </div>
   </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/events.css">
@endsection
@section('script')
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="resources/assets/frontend/js/events.js"></script>
@endsection