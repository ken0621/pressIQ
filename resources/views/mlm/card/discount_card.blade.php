<div class="{{ Request::input('pdf') == 'true' ? '' : 'row' }} clearfix">

<div class="{{ Request::input('pdf') == 'true' ? '' : 'col-md-6' }} clearfix" style="{{ Request::input('pdf') == 'true' ? 'margin-top: 450px;' : '' }}">
	<div class="containers" style="overflow: hidden; {{ Request::input('pdf') == 'true' ? '-webkit-transform: scale(5,5); transform: scale(5,5);' : '' }} ;height: 276px; background-color: transparent; background-image: url('{{Request::input('pdf') == 'true' ? URL::to('/') : ''}}/assets/card/images/BG-{{ $color }}.jpg') !important;">
		<div class="top-container clearfix">
			<span class="website">{{ URL::to('/') }}</span>
			<div class="logo"><img style="width: 200px;" src="{{Request::input('pdf') == 'true' ? public_path() : ''}}/assets/card/images/philtech-logo.png"></div>
		</div>
		<div class="mid-container clearfix" style="margin: 0; height: 149px;"><img style="display: block; width: 380px; margin-left: 15px;" src="{{Request::input('pdf') == 'true' ? public_path() : ''}}/assets/card/images/{{ $color }}-logo.png"></div>
		<div class="bottom-container clearfix" style="margin-top: -7.5px;">
			<div class="member">
				<div class="member-label" style="padding: 0; font-weight: 400;">Discount Card No.</div>
				<div class="member-name">{{ $membership_code }}</div>
			</div>
			<div class="barcode">
				<div class="barcodeimg" style="background-color: #fff; padding: 7.5px 0;"><img src="{{Request::input('pdf') == 'true' ? URL::to('/') : ''}}/barcode?text={{ $membership_code }}&size=35"></div>
				<div class="barcodetxt">
					<span>Membership No.</span>
					<span>{{ $membership_code }}</span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="{{ Request::input('pdf') == 'true' ? '' : 'col-md-6' }} clearfix" style="{{ Request::input('pdf') == 'true' ? 'margin-top: 1000px;' : '' }}">
	<div class="containers" style="{{ Request::input('pdf') == 'true' ? '-webkit-transform: scale(5,5); transform: scale(5,5);' : '' }} height: 276px; background-color: transparent; background-image: url('{{Request::input('pdf') == 'true' ? URL::to('/') : ''}}/assets/card/images/BG-{{ $color }}.jpg') !important;">
		<div style="color: #fff; overflow: hidden;">
			<div class="clearfix" style="text-align: center;">
				<h1 class="clearfix" style="margin: auto; margin-bottom: 5px; width: 100%; max-width: 100%; font-weight: 600;">TERMS AND CONDITION</h1>
			</div>
			<ol class="clearfix" style="padding-left: 20px; font-weight: 600; font-size: 11px; letter-spacing: 1px;">
				<li>The Cardholder agrees to be bound by the Terms and Conditions of the PhilTECH,Inc. Discount Program. Present this card when purchasing products or availing services in the Head Office, all BCO and Partner Merchants Nationwide.</li>
				<li>This card must be sold at Php. 200.00 only. Selling this card at a higher cost is strictly prohibited as it is a violation of the policies of PhilTECH,Inc.</li>
				<li>Transferable</li>
				<li>Renewable after one (1) Year</li>
				<li>Tampering of original signatures invalidates this Card.</li>
			</ol>
			<div class="row clearfix">
				<div class="col-xs-6">
					<img style="width: 100%;" src="/assets/card/images/sign-1.jpg">
				</div>
				<div class="col-xs-6">
					<img style="width: 100%;" src="/assets/card/images/sign-2.jpg">
				</div>
			</div>
		</div>
	</div>
	<br>
</div>

</div>

@if(Request::input('pdf') != 'true')
<!-- <div class="col-md-12">
	<hr>
	<div class="col-md-3">
		{{ $name }}
		Status : @if($info->slot_card_printed == 1) PRINTED @else PENDING @endif
	</div>
	<div class="col-md-3">
		<a class="btn btn-primary" href="/member/mlm/card/image/{{$info->slot_id}}?pdf=true" target="_blank">Export to JPG</a>
	</div>
	<div class="col-md-3">
		<form class="global-submit" method="post" action="/member/mlm/card/done">
		{!! csrf_field() !!}
		<input type="hidden" name="slot_id" value="{{$info->slot_id}}">
		<button class="btn btn-primary" @if($info->slot_card_printed == 1) disabled @endif >Mark Done</button>
		</form>
	</div>
	<div class="col-md-3">
	<form class="global-submit" method="post" action="/member/mlm/card/pending">
		{!! csrf_field() !!}
		<input type="hidden" name="slot_id" value="{{$info->slot_id}}">
		<button class="btn btn-primary"  @if($info->slot_card_printed == 0) disabled @endif >Mark Pending</button>
		</form>
	</div>
	
	
</div> -->
@endif