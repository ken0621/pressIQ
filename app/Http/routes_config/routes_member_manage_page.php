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


Route::any('/member/page/partner/insert', 'Member\Page_ThemesController@partnerinsert');
Route::any('/member/page/partner', 'Member\Page_ThemesController@partner');


Route::any('/member/page/partnerview/filter/{id}', 'Member\Page_ThemesController@view_filtering');
Route::any('/member/page/partnerview', 'Member\Page_ThemesController@partnerview');
Route::any('/member/page/partner/submit_edit/{id}', 'Member\Page_ThemesController@edit_submit');
Route::any('/member/page/partnerview/edit/{id}', 'Member\Page_ThemesController@partnerviewedit');
Route::any('/member/page/partnerview/delete/{id}', 'Member\Page_ThemesController@delete_company_info');
Route::get('/member/page/partnerview/partner-filter-by-location', 'Member\Page_ThemesController@partnerFilterByLocation');


