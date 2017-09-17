<div class="card">
	<div class="upper">
		<div class="profile-image">
			<img src="{{ $sponsor_profile_image }}">
		</div>
	</div>
	<div class="info">
		<div class="name">{{ $sponsor_customer->first_name }} {{ $sponsor_customer->last_name }}</div>
		<div class="email">{{ $sponsor_customer->email }}</div>
		<div class="slotno">SLOT NO. {{ $sponsor->slot_no }}</div>
	</div>
</div>