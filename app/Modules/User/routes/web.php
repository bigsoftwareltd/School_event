<?php

Route::group(['module' => 'user', 'prefix' => 'user', 'middleware' => ['auth', 'verified']], function () {

//    Route::get('/', 'UsersController@index')->name('users.index');
//    Route::get('create', "UsersController@create")->name('users.create');
//    Route::post('store', "UsersController@store")->name('users.store');
//    Route::get('/{user}', "UsersController@show")->name('users.show');
//    Route::get('/{user}/edit', "UsersController@edit")->name('users.edit');
//    Route::delete('/{user}', "UsersController@destroy")->name('users.destroy');


    Route::get('view-user', 'UserController@Viewuser')->name('view-user');
    Route::post('get-user', 'UserController@getList')->name('get_user_list');
    Route::get('add', "UserController@Adduser")->name('user_add');
    Route::post('save', "UserController@userSave")->name('user_save');
    Route::post('update', "UserController@update")->name('user_update');
    Route::get('edit/{id}', "UserController@edit")->name('user_edit');
    Route::post('remove', "UserController@DeleteUser")->name('user_remove');

    // User personal profile update
    Route::get('profile', 'UsersController@profileUpdate');
    Route::post('profile-update', 'UsersController@profileUpdateStore');

    Route::get('change-password', 'UsersController@changePasswordForm');
    Route::post('update-password', 'UsersController@changePasswordStore');

    // User status
    Route::post('status', 'UsersController@userStatus');

});
