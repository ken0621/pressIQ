@extends("press_user.member")
@section("pressview")
	<div class="row-no-padding clearfix">
		<div class="col-md-9">
			<div class="press-view-holder">
				@foreach ($pr as $prs)
				<div class="title-container"><a href="/pressuser/mypressrelease">{{$prs->pr_headline}}</a></div>
				<div class="date-container">{{$prs->pr_date_sent}}</div>
				<div class="details-container">{{$prs->pr_subheading}}
				</div>
				<div class="details-container">{!!$prs->pr_content!!}
				</div>

				@endforeach
			</div>
		</div>
		<div class="col-md-3">
			<div class="press-others-holder">
				<div class="header-container">Other Releases: </div>
				@foreach($opr as $prs)
				<div class="title-container"><a href="/pressuser/mypressrelease/pressrelease/view/{{$prs->pr_id}}">{{$prs->pr_headline}}</a></div>
				<div class="date-container">{{$prs->pr_date_sent}}</div>
				<div class="border"></div>
				@endforeach
			</div>
		</div>
	</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/pressrelease_view.css">
@endsection

@section("script")

@endsection