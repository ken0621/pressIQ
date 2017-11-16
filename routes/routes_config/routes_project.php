<?php

Route::group(array('prefix' => '/member/project'), function()
{
	Route::get('/project_list', 'Member\ProjectController@index');
	Route::get('/project_list/add', 'Member\ProjectController@add');
	Route::post('/project_list/add', 'Member\ProjectController@submit_add');
	Route::get('/project_list/table', 'Member\ProjectController@table');
	Route::get('/project_list/archive', 'Member\ProjectController@archive');
});