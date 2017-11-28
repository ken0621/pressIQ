@extends("layout")
@section("content")
<div class="content">
	<div class="container">
		<div class="wrapper">
			<!-- HEADER -->
			<div class="header">
				<div class="h-container">
					<div class="logo-container">
						<img src="/themes/{{ $shop_theme }}/img/logo-lg.png">
					</div>
					<h1>3XCELL-E SALES & MARKETING INC.</h1>
					<p>
						Unit 202 2nd Floor Vicars Bldg. #31 Visayas Ave.Brgy. Vasra Quezon City<br>
						Telephone No.(02)518-8637
					</p>
				</div>
				<div class="h-container row clearfix">
					<div class="col-md-9"></div>
					<div class="col-md-3">
						<p><span>AR NO.</span><span style="color: #00ac47;">000001{{-- echo slot --}}</span></p>
					</div>
				</div>
				<div class="h-container" style="font-weight: 700; font-size: 18px;">ACKNOWLEDGEMENT RECIEPT</div>
				<div class="h-container row clearfix">
					<div class="col-md-8"></div>
					<div class="col-md-4">
						<p><span>Date:&nbsp;&nbsp;</span><span>00 - 00 - 00{{-- echo slot --}}</span></p>
					</div>
				</div>
			</div>
			<!-- RECIEPT CONTENT -->
			<div class="content">
				<div class="per-container">
					<span class="per-label">Name:</span>&nbsp;&nbsp;<span>{{-- echo slot --}}</span>
				</div>
				<div class="per-container">
					<span class="per-label">Address:</span>&nbsp;&nbsp;<span>{{-- echo slot --}}</span>
				</div>
				<div class="per-container">
					<span class="per-label">Receive the amount of:</span>&nbsp;&nbsp;<span>{{-- echo slot --}}</span>
				</div>
				<div class="row clearfix">
					<div class="col-md-8">
						<table>
							<tr>
								<th class="head-green">DETAILS</th>
							</tr>
							<tr>
								<td>&nbsp;{{-- echo slot --}}</td>
							</tr>
							<tr>
								<td>&nbsp;{{-- echo slot --}}</td>
							</tr>
							<tr>
								<td>&nbsp;{{-- echo slot --}}</td>
							</tr>
							<tr>
								<td>&nbsp;{{-- echo slot --}}</td>
							</tr>
							<tr>
								<td>&nbsp;{{-- echo slot --}}</td>
							</tr>
						</table>
					</div>
					<div class="col-md-4">
						<table>
							<tr>
								<th class="head-blue">AMOUNT</th>
							</tr>
							<tr>
								<td>&nbsp;{{-- echo slot --}}</td>
							</tr>
							<tr>
								<td>&nbsp;{{-- echo slot --}}</td>
							</tr>
							<tr>
								<td>&nbsp;{{-- echo slot --}}</td>
							</tr>
							<tr>
								<td>&nbsp;{{-- echo slot --}}</td>
							</tr>
							<tr>
								<td>&nbsp;{{-- echo slot --}}</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-md-8">
						<div class="remarks">
							REMARKS:
						</div>
					</div>
					<div class="col-md-4">
						<div class="sign"></div>
						<div><span>AUTHORIZED CASHIER</span></div>
					</div>
				</div>
			</div>
			<!-- FOOTER -->
			<div class="footer">
				<p>This Receipt is not valid unless countersigned by our authorized cashier. Defective payment will automatically render this receipt invalid</p>
				<p>"THIS DOCUMENT IS NOT VALID FOR CLAIMING INPUT TAXES"</p>
			</div>
		</div>
	</div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/reciept.css">
@endsection

@section("js")
@endsection