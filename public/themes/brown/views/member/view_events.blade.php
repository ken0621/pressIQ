<div class="modal-body row-no-padding clearfix" style="padding: 0; position: relative;">
	<div class="col-md-8">
		<div class="event-image">
			<img style="width: 100%;" src="/themes/{{ $shop_theme }}/img/event1.jpg">
		</div>
	</div>
	<div class="col-md-4">
		<div class="event-details" style="padding: 40px 15px 15px 15px; text-align: center; position: relative;">
			<h1 style="font-size: 24px; font-weight: 300; margin-top: 50px; color: #404040;">{{ $event->event_title }}</h1>
			<div class="date">
				<span><i class="fa fa-calendar-o" aria-hidden="true"></i></span>&nbsp;&nbsp;<span style="font-weight: 400; color: #585858;">OCTOBER 20, 2017</span>
			</div>
			<p style="font-size: 15px; font-weight: 300; color: #585858; margin-top: 25px;">
				Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
			</p>
			<a href="">
				<div class="reserve-btn" style="width: 90%; background-color: #402a21; text-align: center; padding: 12px 0; color: #fff; font-weight: 300;
				position: absolute; top: 540px;">
					RESERVE A SEAT
				</div>
			</a>
		</div>
	</div>
</div>
<div class="modal-footer" style="display: none;">
	<div class="reserve-btn-2">
		RESERVE A SEAT
	</div>
</div>
<div class="mob-close" style="display: none;" data-dismiss="modal">
	<img src="/themes/{{ $shop_theme }}/img/mob-close.png">
</div>
<style type="text/css">
	.reserve-btn-2
	{
		width: 100%;
		background-color: #402a21;
		text-align: center;
		padding: 12px 0;
		color: #fff;
		font-weight: 300;
	}
	.modal-content-global
	{
		border-radius: 0 !important;
	}
	.reserve-btn:hover
	{
		cursor: pointer;
		background-color: #493026 !important;
	}
	@media screen and (max-width: 425px)
	{
		.event-details
		{
			padding: 5px 10px 25px 10px !important;
		}
		.reserve-btn
		{
			display: none !important;
		}
		.modal-footer
		{
			display: block !important;
		}
		.mob-close
		{
			display: block !important;
			position: absolute;
			top: 5px;
			right: 3px;
		}
	}
</style>