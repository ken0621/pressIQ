<div class="container">
	<div class="wrapper-1">
		<div class="texts-1">Transaction Reference Number for this transaction is</div>
		<div class="order">{{ str_pad($transaction->transaction_number, 8, '0', STR_PAD_LEFT) }}</div>
		<div class="amount">{{ $transaction_total }}</div>
		<div class="texts-2">E-Mail for this link has been sent to your e-mail address.<br>You can click below to upload your proof of payment.</div>

		<div class="file-container">
			<form method="post" class="upload-proof-of-payment" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input class="payment-proof" type="file" name="proofupload">
			</form>
		</div>
	</div>
</div>

<div class="wrapper-2">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-md-6">
				<div class="account-list-container">
					<div class="text-header">ACCOUNT LIST</div>
					<div class="content">{!! $api->api_client_id !!}</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="step-by-step-container">
					<div class="text-header">STEP BY STEP INSTRUCTION</div>
					<div class="content">{!! $api->api_secret_id !!}</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- BOOTSTRAP -->
<link rel="stylesheet" href="/assets/initializr/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/initializr/css/bootstrap-theme.min.css">

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/assets/member/css/manual_checkout.css">

<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$(".payment-proof").change(function()
		{
			$(".upload-proof-of-payment").submit();
		});
	});
</script>