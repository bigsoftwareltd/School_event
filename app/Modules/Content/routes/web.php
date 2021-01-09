<?php

Route::group(['module' => 'content', 'prefix' => 'content', 'middleware' => ['auth', 'verified']], function () {

    Route::get('view-content', 'ContentController@ViewContent')->name('view-content');
    Route::post('get-content', 'ContentController@getContent')->name('get_content_list');
    Route::post('save-content', "ContentController@SaveContent")->name('save_content');
    Route::post('update', "ContentController@UpdateContent")->name('user_update');
    Route::get('edit/{id}', "ContentController@EditContent")->name('edit_content');
    Route::post('remove-content', "ContentController@DeleteContent")->name('remove_content');


});
