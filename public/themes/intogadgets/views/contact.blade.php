@extends('layout')
@section('content')
<div class="contact">
	<div class="contact-header">
		<div class="title">LEAVE US A <span>MESSAGE</span></div>
		<div class="sub">Whether you have a question about bulk orders,</br> 
need assistance on payment options, or just wanted to drop a</br> line,we want to know what’s on your mind.</div>
		<div class="text">We’ll help you get yours orders out.</div>
		<div class="icon">
			<div class="holder">
				<i class="fa fa-phone"></i>
				<div class="text">+63932-187-9511</br>+63916-336-2012</div>
			</div>
			<div class="holder">
				<i class="fa fa-map-marker"></i>
				<div class="text">Store Locations</div>
			</div>
			<div class="holder">
				<i class="fa fa-facebook"></i>
				<div class="text">facebook.com/intogadgetstore</div>
			</div>
			<div class="holder">
				<i class="fa fa-twitter"></i>
				<div class="text">twitter.com/intogadgetstore</div>
			</div>
			<div class="holder">
				<i class="fa fa-instagram"></i>
				<div class="text">instagram.com/intogadgetstore</div>
			</div>
		</div>
	</div>
	<div class="store-content container">
		@if(isset($_data) && $_data)
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
					@foreach($_data as $store)
					<tr>
						<td>{!! $store->url == "" ? "<img src='$store->show_image'>": "<a data-fancybox-group='gallery' class='fancybox' id='fancyboxes' href='$store->url'><img src='$store->show_image'></img></a>" !!}</td>
						<td class="storename">{{$store->store_name}}</td>
						<td>{{$store->store_branch}}</td>
						<td>{{$store->store_contact_number}}</td>
						<td>{!!$store->store_location == "" ? "<a href='/contact#'>" : "<a href='http://$store->store_location'>" !!}View</a></td>
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
