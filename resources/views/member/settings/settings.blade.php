<!--
	Put your setting form here
	Set your data at SettingsController
	The class of div must contain class "setting" and id "name of the settings"
	Inside the div it must contain an input with settings_key and settings_value
-->

<!-- Curreny Settings -->
	<div class="settings" id="currency">
		Currency
		<input type="hidden" name="settings_key[]" value="currency">
		<select name="settings_value[]" class="form-control"> 
			@foreach($currency as $cur)
				<option value="{{$cur->iso}}">{{$cur->name}}</option>
			@endforeach
		</select>
	</div>
<!-- End Currency Settings -->

<!-- Country Settings -->
	<div class="settings" id="country">
		Country
		<input type="hidden" name="settings_key[]" value="country">
		<select name="settings_value[]" class="form-control">
			@foreach($country as $cou)
				<option value="{{$cou->country_name}}">{{$cou->country_name}}</option>
			@endforeach
		</select>
	</div>
<!-- End country Settings -->

<!-- Item Serial Settings -->
	<div class="settings" id="item_serial">
		Require Item Serial
		<input type="hidden" name="settings_key[]" value="item_serial">
		<select name="settings_value[]" class="form-control">
			<option value="enable">Enable</option>
			<option value="disable">Disable</option>
		</select>
	</div>
<!-- Item Serial Settings -->

<!-- Bad Order Settings -->
	<hr>
	<center>Debit Memo</center>
	<div class="settings" id="debit_memo">
		Enable Debit Memo For Service Type transaction
		<input type="hidden" name="settings_key[]" value="debit_memo">
		<select name="settings_value[]" class="form-control">
			<option value="enable">Enable</option>
			<option value="disable">Disable</option>
		</select>
	</div>
	<div class="settings" id="bad_order">
		Enable Bad Oder for Replacing Item
		<input type="hidden" name="settings_key[]" value="bad_order">
		<select name="settings_value[]" class="form-control">
			<option value="enable">Enable</option>
			<option value="disable">Disable</option>
		</select>
	</div>
<!-- Bad Order Settings -->

	<hr>
	<center>MLM</center>
<!-- Item Serial Settings -->
	<div class="settings" id="use_product_as_membership">
		Use Product as Membership
		<input type="hidden" name="settings_key[]" value="use_product_as_membership">
		<select name="settings_value[]" class="form-control">
			<option value="0">Disable</option>
			<option value="1">Enable</option>
		</select>
	</div>

	<div class="settings" id="enable_consume_on_pending">
		Enable Consume Inventory on Pending Order
		<input type="hidden" name="settings_key[]" value="enable_consume_on_pending">
		<select name="settings_value[]" class="form-control">
			<option value="0">Disable</option>
			<option value="1">Enable</option>
		</select>
	</div>
<!-- Item Serial Settings -->


	<hr>
	<center>Ecommerce</center>
<!-- View invoice in Order -->
	<div class="settings" id="enable_view_invoice">
		View Invoice in Product Orders
		<input type="hidden" name="settings_key[]" value="enable_view_invoice">
		<select name="settings_value[]" class="form-control">
			<option value="0">Disable</option>
			<option value="1">Enable</option>
		</select>
	</div>

	<hr>
	<center>Accounting - Taylormade</center>
	<!-- Customer with Unit -->
	<div class="settings" id="customer_unit_receive_payment">
		Customer with Unit in Receive Payment
		<input type="hidden" name="settings_key[]" value="customer_unit_receive_payment">
		<select name="settings_value[]" class="form-control">
			<option value="0">Disable</option>
			<option value="1">Enable</option>
		</select>
	</div>


	<hr>
	<center>Accounting - WIS/DR</center>
	<!-- Customer with Unit -->
	<div class="settings" id="customer_wis">
		Warehouse Issuance Slip / Delivery Receipt
		<input type="hidden" name="settings_key[]" value="customer_wis">
		<select name="settings_value[]" class="form-control">
			<option value="0">Disable</option>
			<option value="1">Enable</option>
		</select>
	</div>
