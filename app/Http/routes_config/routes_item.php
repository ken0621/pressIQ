<?php
Route::group(array('prefix' => '/member/item/'), function()
{
	Route::any('/v2','Member\ItemControllerV2@list');
	Route::any('/v2/table','Member\ItemControllerV2@list_table');
	Route::any('/v2/add','Member\ItemControllerV2@add_item');
	Route::any('/v2/cost','Member\ItemControllerV2@cost');
	Route::any('/v2/price_level','Member\ItemControllerV2@price_level');
});