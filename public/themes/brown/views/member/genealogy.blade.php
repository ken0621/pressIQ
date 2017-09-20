@extends("member.member_layout")
@section("member_content")
<div class="genealogy-container">
	<div class="genealogy-header clearfix">
		<div class="left">
			
			<div class="icon">
				<div class="brown-icon-genealogy" style="font-size: 40px;"></div>
			</div>
			<div class="text">
				<div class="name">Genealogy</div>
			</div>
		</div>
		<div class="right">
			<div class="legend">
				<div class="legend-label">Legend:</div>
				<div class="legend-select">
					<select class="form-control">
						<option>Occupied Slot</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="genealogy-content">
		<iframe frameborder="0"  width="100%" height="550px" src="/members/genealogy-tree?slot_id={{$slot_id}}&mode={{$mode}}"></iframe>
	</div>
</div>
@endsection
@section("member_script")
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/genealogy.css">
@endsection