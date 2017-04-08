@extends('layout')
@section('content')
<div class="contact">
	<div class="contact-header" style="background-image: url('{{ get_content($shop_theme_info, 'contact', 'contact_header_cover') }}')">
		<div class="title">{{ get_content($shop_theme_info, 'contact', 'contact_title') }}</div>
		<div class="sub">{{ get_content($shop_theme_info, 'contact', 'contact_subtitle') }}</div>
		<div class="text" style="color: #fff;">{{ get_content($shop_theme_info, 'contact', 'contact_quote') }}</div>
		<div class="icon">
			<!-- <div class="holder">
				<i class="fa fa-phone"></i>
				<div class="text">+63932-187-9511</br>+63916-336-2012</div>
			</div> -->
			<div class="holder">
				<a style="color: #fff;" href="{{ get_content($shop_theme_info, 'contact', 'contact_location_link') }}">
					<i class="fa fa-map-marker"></i>
					<div class="text">Store Locations</div>
				</a>
			</div>
			<div class="holder">
				<a style="color: #fff;" href="{{ get_content($shop_theme_info, 'contact', 'contact_facebook_link') }}">
					<i class="fa fa-facebook"></i>
					<div class="text">{{ get_content($shop_theme_info, 'contact', 'contact_facebook_link') }}</div>
				</a>
			</div>
			<div class="holder">
				<a style="color: #fff;" href="{{ get_content($shop_theme_info, 'contact', 'contact_twitter_link') }}">
					<i class="fa fa-twitter"></i>
					<div class="text">{{ get_content($shop_theme_info, 'contact', 'contact_twitter_link') }}</div>
				</a>
			</div>
			<div class="holder">
				<a style="color: #fff;" href="{{ get_content($shop_theme_info, 'contact', 'contact_instagram_link') }}">
					<i class="fa fa-instagram"></i>
					<div class="text">{{ get_content($shop_theme_info, 'contact', 'contact_instagram_link') }}</div>
				</a>
			</div>
		</div>
	</div>
	<div class="store-content container">
		@if(is_serialized(get_content($shop_theme_info, "contact", "contact_store_maintenance")))
		<div>
			<table id="branches">
				<thead>
					<tr>
						<th>Store Image</th>
						<th data-hide="phone,tablet">Store Name</th>
						<th data-hide="phone">Store Branch</th>
						<th data-hide="phone,tablet">Contact Number</th>
						<th data-hide="phone,tablet">Location</th>
					</tr>
				</thead>
				<tbody>
					@foreach(unserialize(get_content($shop_theme_info, "contact", "contact_store_maintenance")) as $store)
					<tr>
						<td><a data-fancybox-group='gallery' class='fancybox' id='fancyboxes' href='{{ $store["image"] }}'><img src='{{ $store["image"] }}'></img></a></td>
						<td class="storename">{{$store["name"]}}</td>
						<td>{{$store["branch"]}}</td>
						<td>{{$store["contact"]}}</td>
						<td><a href='{{ $store["link"] }}'>View</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@endif
	</div>
	<div class="contact-content container">
		<form id="email-form" action="" method="">
			{!!Honeypot::generate('my_name','my_time')!!}
			<div id="email-form-result">

			</div>
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

			<div class="col-md-6 left nopadding" style="padding-right: 25px !important;">

			<div class="field">
				<input type="text" name="sender_name" placeholder="FULL NAME">
			</div>
			<div class="field">
				<input type="text" name="sender_contact_num" placeholder="PHONE NUMBER">
			</div>
			<div class="field">
				<input type="text" name="sender_email" placeholder="YOUR EMAIL">
			</div>
		</div>
		<div class="col-md-6 right nopadding">
			<div class="field">
				<textarea name="sender_message" placeholder="Your Message Here...."></textarea>
				<button id="send-email">Send <i class="fa fa-paper-plane-o"></i></button>
				<img id="sending-message-loading" style="display: none;" src="../../resources/assets/img/small-loading.GIF" alt="">
			</div>
		</div>
		</form>
	</div>
</div>
@endsection
<style type="text/css">

</style>
@section('script')
	<script type="text/javascript" src="resources/assets/rutsen/js/contact.js"></script>
	<script type="text/javascript" src="resources/assets/fbox/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="resources/assets/fbox/jquery.fancybox.css?v=2.1.5" media="screen" />
	<script type="text/javascript" src="resources/assets/frontend/js/store.js"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$('body').on('click', '.footable .footable-row-detail', function(event) 
			{
				event.preventDefault();
				$(event.currentTarget).prev("tr").toggleClass("hid");
			});

			$('.footable-toggle').trigger('click');
			$('.footable-toggle').trigger('click');

			$('.footable .footable-row-detail').prev("tr").addClass("hid");
			
			var $message_result = $('#email-form-result');
			$('button#send-email').on('click', function(e)
			{
				e.preventDefault();
				var loading = $('#sending-message-loading');
				loading.fadeIn();
				var $form = $('#email-form').serialize();
				console.log($form);


				$.ajax({
					url: 'contact/send_email',
					type: 'post',
					dataType: 'json',
					data: $form,
				})
				.done(function(data) {
					loading.fadeOut();
					$message_result.html("");
					$message_result.removeAttr("class");
					var append = '<p>'+data['message']+'</p>';
					var error = "";
					if(data['error'] != null)
					{
						$.each(data['error'], function(index, val)
						{
							error += "<li>"+val+"</li>";
						});
					}

					error = '<ul>'+error+'</ul>';
					$message_result.append(append+error);

					if(data['success'])
					{
						$message_result.addClass('alert alert-success');
						$( '#email-form input[name="sender_name"]').val("");
						$( '#email-form input[name="sender_contact_num"]').val("");
						$( '#email-form input[name="sender_email"]').val("");
						$( '#email-form textarea[name="sender_message"]').val("");

						setTimeout(function(){
							$message_result.fadeOut();
						}, 5000)

						
					}
					else
					{
						$message_result.addClass('alert alert-danger');
					}



					

				})
				.fail(function() {
					console.log("error");
					loading.fadeOut();
				})
				.always(function() {
					console.log("complete");
				});
				
				
			});	
		});
	</script>
@endsection

@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/contact.css">
@endsection
