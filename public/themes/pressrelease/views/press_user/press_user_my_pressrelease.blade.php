@extends("press_user.member")
@section("pressview")
<div class="background-container">
    <div class="pressview">
        <div class="my-press-release-container">
            @foreach ($pr as $prs)
        	<div class="title-container"><a href="/pressuser/mypressrelease/pressrelease/view/{{$prs->pr_id}}">{{$prs->pr_headline}}</a></div>
        	<div class="date-container">{{$prs->pr_date_sent}}</div>
            <div class="details-container">
                <p>{!!$prs->pr_content!!}</p>
            </div>
        	<div class="border"></div>
            @endforeach
        </div>
        <div class="my-press-release-container-container" style="border-bottom: none;" >
            {!! $pr->render() !!}
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/press_user_my_pressrelease.css">
@endsection

@section("script")

@endsection