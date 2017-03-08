<!--
	Put your setting form here
	Set your data at SettingsController
	The class of div must contain class "setting" and id "name of the settings"
	Inside the div it must contain an input with settings_key and settings_value
-->

<!-- Curreny Settings -->
	<div class="settings" id="currency">
		Currency
		<input type="hidden" name="settings_key" value="currency">
		<select name="settings_value" class="form-control"> 
			@foreach($currency as $cur)
				<option value="{{$cur->iso}}">{{$cur->name}}</option>
			@endforeach
		</select>
	</div>
<!-- End Currency Settings -->

<!-- Country Settings -->
	<div class="settings" id="country">
		Country
		<input type="hidden" name="settings_key" value="country">
		<select name="settings_value" class="form-control">
			@foreach($country as $cou)
				<option value="{{$cou->country_name}}">{{$cou->country_name}}</option>
			@endforeach
		</select>
	</div>
<!-- End country Settings -->

<!-- Item Serial Settings -->
	<div class="settings" id="item_serial">
		Require Item Serial
		<input type="hidden" name="settings_key" value="item_serial">
		<select name="settings_value" class="form-control">
			<option value="enable">Enable</option>
			<option value="disable">Disable</option>
		</select>
	</div>
<!-- Item Serial Settings -->
