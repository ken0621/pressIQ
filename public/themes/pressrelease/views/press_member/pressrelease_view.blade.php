@extends("layout")
@section("content")
<div class="background-container" style="background-image: url('/themes/{{ $shop_theme }}/img/home-banner.jpg')">
	<div class="container">
		<div class="row-no-padding clearfix">
			<div class="col-md-9">
				<div class="press-view-holder">
					<div class="title-container"><a href="/pressmember">Press Release 1</a></div>
					<div class="date-container">November 25, 2017</div>
					<div class="details-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod corporis possimus laboriosam
					</div>
					<div class="details-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse ipsam mollitia velit, dicta optio, magni harum! Alias vero, doloremque, illo et nihil pariatur quidem, quia libero nisi reiciendis ut? Modi a corporis nesciunt, ullam commodi nostrum dolor dolores sint, molestias tenetur, delectus accusantium sunt sit, natus repellat. Ab tenetur commodi fugiat modi vero error, veritatis eligendi aut voluptas quae praesentium?
					</div>
					<div class="details-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse ipsam mollitia velit, dicta optio, magni harum! Alias vero, doloremque, illo et nihil pariatur quidem, quia libero nisi reiciendis ut? Modi a corporis nesciunt, ullam commodi nostrum dolor dolores sint, molestias tenetur, delectus accusantium sunt sit, natus repellat. Ab tenetur commodi fugiat modi vero error, veritatis eligendi aut voluptas quae praesentium?
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="press-others-holder">
					<div class="title-container"><a href="/pressmember/view">Press Release 1</a></div>
					<div class="date-container">November 25, 2017</div>
					<div class="border"></div>
					<div class="title-container"><a data-toggle="tab" href="#">Press Release 2</a></div>
					<div class="date-container">November 25, 2017</div>
					<div class="border"></div>
					<div class="title-container"><a data-toggle="tab" href="#">Press Release 3</a></div>
					<div class="date-container">November 25, 2017</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/pressrelease_view.css">
@endsection

@section("script")

<script type="text/javascript">

@endsection