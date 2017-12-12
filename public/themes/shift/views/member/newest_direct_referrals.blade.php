@if(count($_direct) > 0)
	@foreach($_direct as $direct)
	<div class="holder">
		<div class="row clearfix">
			<div class="col-md-7">
				<div class="color">
					<img src="{{ $direct->profile_image }}">
				</div>	
				<div class="text">
					<div class="pull-left">
						<div class="name">{{ $direct->first_name }} {{ $direct->last_name }}</div>
						<div class="email">{{ $direct->slot_no }}</div>
						<div class="date">{{ $direct->time_ago }}</div>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="action align-custom">
					@if($direct->distributed == 1)
						<button onclick="action_load_link_to_modal('/members/slot-info?slot_no={{ Crypt::encrypt($direct->slot_id) }}&key={{ md5($direct->slot_id . $direct->slot_no) }}')" class="btn btn-shift-view-info"><i class="fa fa-star"></i> VIEW INFO</button>
					@else
						<button class="btn btn-danger place_slot_btn" place_slot_id="{{$direct->slot_id}}"><i class="fa fa-warning"></i> PLACE THIS SLOT</button>
					@endif
				</div>
			</div>
		</div>
	</div>
	@endforeach
	<div class="clearfix">
		<div class="pull-right">
		{!! $_direct->render() !!}
		</div>
	</div>
@else
	<div class="text-center" style="padding: 20px">You don't have any direct referral yet.</div>
@endif

