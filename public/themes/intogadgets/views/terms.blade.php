 @section('content')
 @extends('layout')

 <div class="about-container">
 	<div class="about-header container text-left">
 		{!! $terms_and_agreement->settings_value !!}
 	</div>
 </div>
 @endsection
@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/about.css">
@endsection