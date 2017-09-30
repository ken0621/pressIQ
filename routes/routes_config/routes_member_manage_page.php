<?php
/* MEMBER - MANAGE PAGE - THEMES */ 
Route::get('/member/page/themes', 'Member\Page_ThemesController@index');
/* MEMBER - MANAGE PAGE - THEMES - POP ACTIVATE */ 
Route::post('/member/page/themes/activate_submit', 'Member\Page_ThemesController@popup_activate_submit');
/* MEMBER - MANAGE PAGE - THEMES - POP ACTIVATE (SUBMIT) */ 
Route::get('/member/page/themes/{id}', 'Member\Page_ThemesController@popup_activate_form');
/* MEMBER - MANAGE PAGE - CONTENT */ 
AdvancedRoute::controller('/member/page/content', 'Member\Page_ContentController');
/* MEMBER - MANAGE PAGE - POST */ 
AdvancedRoute::controller('/member/page/post', 'Member\Page_PostController');


Route::any('/member/page/partner/insert', 'Member\Page_ThemesController@partnerinsert');
Route::any('/member/page/partner', 'Member\Page_ThemesController@partner');


Route::any('/member/page/partnerview/filter/{id}', 'Member\Page_ThemesController@view_filtering');
Route::any('/member/page/partnerview', 'Member\Page_ThemesController@partnerview');
Route::any('/member/page/partner/submit_edit/{id}', 'Member\Page_ThemesController@edit_submit');
Route::any('/member/page/partnerview/edit/{id}', 'Member\Page_ThemesController@partnerviewedit');
Route::any('/member/page/partnerview/delete/{id}', 'Member\Page_ThemesController@delete_company_info');
Route::get('/member/page/partnerview/partner-filter-by-location', 'Member\Page_ThemesController@partnerFilterByLocation');

/*Press Release Email System*/
Route::get('/member/page/press_release_email/create_press_release', 'Member\Press_Release_Controller@press_create_email');


