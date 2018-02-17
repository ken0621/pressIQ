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
				<option value="{{$cur->iso}}" {{isset($_settings['currency']) ? ($_settings['currency'] == $cur->iso ? 'selected' : '') : ''}} >{{$cur->name}}</option>
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
				<option value="{{$cou->country_name}}" {{isset($_settings['country']) ? ($_settings['country'] == $cou->country_name ? 'selected' : '') : ''}}>{{$cou->country_name}}</option>
			@endforeach
		</select>
	</div>
<!-- End country Settings -->

<!-- Item Serial Settings -->
	<div class="settings" id="item_serial">
		Require Item Serial
		<input type="hidden" name="settings_key[]" value="item_serial">
		<select name="settings_value[]" class="form-control">
			<option value="enable" {{isset($_settings['item_serial']) ? ($_settings['item_serial'] == 'enable' ? 'selected' : '') : ''}}>Enable</option>
			<option value="disable" {{isset($_settings['item_serial']) ? ($_settings['item_serial'] == 'disable' ? 'selected' : '') : ''}}>Disable</option>
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
			<option value="enable"  {{isset($_settings['debit_memo']) ? ($_settings['debit_memo'] == 'enable' ? 'selected' : '') : ''}}>Enable</option>
			<option value="disable"  {{isset($_settings['debit_memo']) ? ($_settings['debit_memo'] == 'disable' ? 'selected' : '') : ''}}>Disable</option>
		</select>
	</div>
	<div class="settings" id="bad_order">
		Enable Bad Oder for Replacing Item
		<input type="hidden" name="settings_key[]" value="bad_order">
		<select name="settings_value[]" class="form-control">
			<option value="enable" {{isset($_settings['bad_order']) ? ($_settings['bad_order'] == 'enable' ? 'selected' : '') : ''}}>Enable</option>
			<option value="disable" {{isset($_settings['bad_order']) ? ($_settings['bad_order'] == 'disable' ? 'selected' : '') : ''}}>Disable</option>
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
			<option value="0"  {{isset($_settings['use_product_as_membership']) ? ($_settings['use_product_as_membership'] == '0' ? 'selected' : '') : ''}}>Disable</option>
			<option value="1"  {{isset($_settings['use_product_as_membership']) ? ($_settings['use_product_as_membership'] == '1' ? 'selected' : '') : ''}}>Enable</option>
		</select>
	</div>

	<div class="settings" id="enable_consume_on_pending">
		Enable Consume Inventory on Pending Order
		<input type="hidden" name="settings_key[]" value="enable_consume_on_pending">
		<select name="settings_value[]" class="form-control">
			<option value="0"   {{isset($_settings['enable_consume_on_pending']) ? ($_settings['enable_consume_on_pending'] == '0' ? 'selected' : '') : ''}}>Disable</option>
			<option value="1"   {{isset($_settings['enable_consume_on_pending']) ? ($_settings['enable_consume_on_pending'] == '1' ? 'selected' : '') : ''}}>Enable</option>
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
			<option value="0"  {{isset($_settings['enable_view_invoice']) ? ($_settings['enable_view_invoice'] == '0' ? 'selected' : '') : ''}}>Disable</option>
			<option value="1"  {{isset($_settings['enable_view_invoice']) ? ($_settings['enable_view_invoice'] == '1' ? 'selected' : '') : ''}}>Enable</option>
		</select>
	</div>

	<hr>
	<center>Accounting - Taylormade</center>
	<!-- Customer with Unit -->
	<div class="settings" id="customer_unit_receive_payment">
		Customer with Unit in Receive Payment
		<input type="hidden" name="settings_key[]" value="customer_unit_receive_payment">
		<select name="settings_value[]" class="form-control">
			<option value="0" {{isset($_settings['customer_unit_receive_payment']) ? ($_settings['customer_unit_receive_payment'] == '0' ? 'selected' : '') : ''}}>Disable</option>
			<option value="1" {{isset($_settings['customer_unit_receive_payment']) ? ($_settings['customer_unit_receive_payment'] == '1' ? 'selected' : '') : ''}}>Enable</option>
		</select>
	</div>


	<hr>
	<center>Accounting - WIS/DR</center>
	<!-- Customer with Unit -->
	<div class="settings" id="customer_wis">
		Warehouse Issuance Slip / Delivery Receipt
		<input type="hidden" name="settings_key[]" value="customer_wis">
		<select name="settings_value[]" class="form-control">
			<option value="0" {{isset($_settings['customer_wis']) ? ($_settings['customer_wis'] == '0' ? 'selected' : '') : ''}}>Disable</option>
			<option value="1" {{isset($_settings['customer_wis']) ? ($_settings['customer_wis'] == '1' ? 'selected' : '') : ''}}>Enable</option>
		</select>
	</div>

	<center>Accounting</center>
	<!-- Customer with Unit -->
	<div class="settings" id="customer_wis">
		Allow Out of Stock
		<input type="hidden" name="settings_key[]" value="out_of_stock">
		<select name="settings_value[]" class="form-control">
			<option value="1" {{isset($_settings['out_of_stock']) ? ($_settings['out_of_stock'] == '1' ? 'selected' : '') : ''}}>Yes</option>
			<option value="0" {{isset($_settings['out_of_stock']) ? ($_settings['out_of_stock'] == '0' ? 'selected' : '') : ''}}>No</option>
		</select>
	</div>

	<center>Notification</center>

	<div class="settings" id="customer_wis">
		Notify me on Notification bar
		<input type="hidden" name="settings_key[]" value="notification_bar">
		<select name="settings_value[]" class="form-control">
			<option value="1" {{isset($_settings['notification_bar']) ? ($_settings['notification_bar'] == '1' ? 'selected' : '') : ''}}>Yes</option>
			<option value="0" {{isset($_settings['notification_bar']) ? ($_settings['notification_bar'] == '0' ? 'selected' : '') : ''}}>No</option>
		</select>
	</div>

	<div class="settings" id="customer_wis">
		Popup Notification for Reorder Items
		<input type="hidden" name="settings_key[]" value="reorder_item">
		<select name="settings_value[]" class="form-control">
			<option value="1" {{isset($_settings['reorder_item']) ? ($_settings['reorder_item'] == '1' ? 'selected' : '') : ''}}>Yes</option>
			<option value="0" {{isset($_settings['reorder_item']) ? ($_settings['reorder_item'] == '0' ? 'selected' : '') : ''}}>No</option>
		</select>
	</div>
