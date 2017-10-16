<div style="text-align: center;"">
	<div>Transaction Reference Number for this transaction is
		<div style="font-size: 25px;"><b>{{ str_pad($transaction->transaction_number, 8, '0', STR_PAD_LEFT) }}</b></div>
		<div style="color: red; font-size: 20px;">{{ $transaction_total }}</div>


		<div style="margin-top: 10px;">E-Mail for this link has been sent to your e-mail address.<br>You can click below to upload your proof of payment.</div>
		<div style="margin-top: 20px">
			<div style="border: 1px solid #eee; display: inline-block; padding: 15px; border-radius: 3px; cursor: pointer;">
				<form method="post" class="upload-proof-of-payment" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input class="payment-proof" type="file" name="proofupload">
				</form>
			</div>
		</div>
	</div>
</div>

<div style="text-align: center; margin-top: 30px;">
	<div style="float: left; width: 50%">
		<div style="border: 1px solid #eee; margin: 10px; padding: 10px;">
			<div style="font-weight: bold; margin-bottom: 20px;">ACCOUNT LIST</div>
			<div style="text-align: left; margin-top: 10px; white-space: pre-wrap">{!! $api->api_client_id !!}</div>
		</div>
	</div>
	<div style="float: right; width: 50%">
		<div style="border: 1px solid #eee; margin: 10px; padding: 10px;">
			<div style="font-weight: bold; margin-bottom: 20px;">STEP BY STEP INSTRUCTION</div>
			<div style="text-align: left; margin-top: 10px; white-space: pre-wrap"">{!! $api->api_secret_id !!}</div>
		</div>
	</div>
</div>

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