<div class="modal-body row-no-padding clearfix" style="padding: 0; position: relative;">
	<div class="col-md-8">
		<div class="event-image">
			<img style="width: 100%;" src="{{$event->event_banner_image}}">
		</div>
	</div>
	<div class="col-md-4">
		<div class="event-details">
			<h1>{{ $event->event_title }}</h1>
			<div class="date">
				<span><i class="fa fa-calendar-o" aria-hidden="true"></i></span>&nbsp;&nbsp;<span style="font-weight: 400; color: #585858;">{{strtoupper(date('F d, Y', strtotime($event->event_date)))}}</span>
			</div>
			<p>
				{!! $event->event_description !!}
			</p>
			<a  class="popup" size="md" link="{!! isset($reserve_seat_btn) ? $reserve_seat_btn : '/members/event-reserve?id='.$event->event_id !!}">
				<div class="reserve-btn">
					RESERVE A SEAT
				</div>
			</a>
		</div>
	</div>
</div>
<div class="modal-footer" style="display: none;">
	<div class="reserve-btn-2">
		<a style="text-decoration: none; color: #fff !important;" class="popup" size="md" link="{!! isset($reserve_seat_btn) ? $reserve_seat_btn : '/members/event-reserve?id='.$event->event_id !!}">
			RESERVE A SEAT
		</a>
	</div>
</div>
<div class="mob-close" style="display: none;" data-dismiss="modal">
	<img src="/themes/{{ $shop_theme }}/img/mob-close.png">
</div>
<style type="text/css">
	.event-details
	{
		padding: 40px 15px 15px 15px;
		text-align: center;
		position: relative;
		color: #404040;
	}
	h1
	{
		font-size: 24px;
		font-weight: 300;
		margin-top: 50px;
	}
	p
	{
		font-size: 15px;
		font-weight: 300;
		color: #585858;
		margin-top: 25px;
	}
	.reserve-btn
	{
		width: 90%;
		background-color: #402a21;
		text-align: center;
		padding: 12px 0;
		color: #fff;
		font-weight: 300;
		position: absolute;
		top: 540px;
	}
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
	@media screen and (max-width: 991px)
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