@extends("member.member_layout")
@section("member_content")
	@include('member2.include_member_network')
@endsection

@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/report.css">
@endsection