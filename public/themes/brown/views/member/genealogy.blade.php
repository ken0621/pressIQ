@extends("member.member_layout")
@section("member_content")
<div class="genealogy-container">
	<div class="genealogy-header clearfix">
		<div class="left">
			<div class="icon">
				<img src="/themes/{{ $shop_theme }}/img/genealogy.png">
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
		<iframe src="" frameborder="0" style="overflow:hidden; height:100%; width:100%" height="100%" width="100%"></iframe>
	</div>
</div>
@endsection
@section("member_script")
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/genealogy.css">
@endsection