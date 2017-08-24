<?php
Route::group(array('prefix' => '/member/item/'), function()
{
	Route::any('/v2','Member\ItemControllerV2@list');
});