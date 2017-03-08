<?php
/* MEMBER - MANAGE PAGE - THEMES */ 
Route::get('/member/page/themes', 'Member\Page_ThemesController@index');
/* MEMBER - MANAGE PAGE - THEMES - POP ACTIVATE */ 
Route::post('/member/page/themes/activate_submit', 'Member\Page_ThemesController@popup_activate_submit');
/* MEMBER - MANAGE PAGE - THEMES - POP ACTIVATE (SUBMIT) */ 
Route::get('/member/page/themes/{id}', 'Member\Page_ThemesController@popup_activate_form');
/* MEMBER - MANAGE PAGE - CONTENT */ 
Route::controller('/member/page/content', 'Member\Page_ContentController');
/* MEMBER - MANAGE PAGE - POST */ 
Route::controller('/member/page/post', 'Member\Page_PostController');