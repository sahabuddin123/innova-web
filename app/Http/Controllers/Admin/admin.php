<?php
Route::Auth();
Route::group(['prefix'  =>  'admin'], function () {

    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
    Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');
    /**
    *Admin Password Reset
    */
    Route::post('/password/email','Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email'); 
    Route::get('/password/reset','Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset','Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}','Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::get('/changePassword','Admin\ChangePasswordController@showChangePasswordForm')->name('admin.changePassword');
    Route::post('/changePassword','Admin\ChangePasswordController@changePassword')->name('changePassword');
/**
 * Dashboard
 */
    Route::group(['middleware' => ['auth:admin']], function () {

        

        // Route::get('/', function () {
        //     return view('admin.dashboard.index');
        // })->name('admin.dashboard')
        Route::get('/', 'Admin\DeshboardController@index')->name('admin.dashboard');
        /**
         * Storage link in server
         */
        Route::get('/storagelink', function () {
            Artisan::call('storage:link');
        });

        Route::get('/settings', 'Admin\SettingController@index')->name('admin.settings');
        Route::post('/settings', 'Admin\SettingController@update')->name('admin.settings.update');

        Route::group(['prefix'  =>   'courses'], function() {

            Route::get('/', 'Admin\CoursesController@index')->name('admin.courses.index');
            Route::get('/create', 'Admin\CoursesController@create')->name('admin.courses.create');
            Route::post('/store', 'Admin\CoursesController@store')->name('admin.courses.store');
            Route::get('/{id}/view', 'Admin\CoursesController@show')->name('admin.courses.view');
            Route::get('/{id}/edit', 'Admin\CoursesController@edit')->name('admin.courses.edit');
            Route::post('/update', 'Admin\CoursesController@update')->name('admin.courses.update');
            Route::get('/{id}/delete', 'Admin\CoursesController@delete')->name('admin.courses.delete');

        });

        Route::group(['prefix'  =>   'batchs'], function() {

            Route::get('/', 'Admin\BatchsController@index')->name('admin.batchs.index');
            Route::get('/create', 'Admin\BatchsController@create')->name('admin.batchs.create');
            Route::post('/store', 'Admin\BatchsController@store')->name('admin.batchs.store');
            Route::get('/{id}/view', 'Admin\BatchsController@show')->name('admin.batchs.view');
            Route::get('/{id}/edit', 'Admin\BatchsController@edit')->name('admin.batchs.edit');
            Route::post('/update', 'Admin\BatchsController@update')->name('admin.batchs.update');
            Route::get('/{id}/delete', 'Admin\BatchsController@delete')->name('admin.batchs.delete');

        });

        Route::group(['prefix'  =>   'students'], function() {

            Route::get('/', 'Admin\StudentsController@index')->name('admin.students.index');
            Route::get('/create', 'Admin\StudentsController@create')->name('admin.students.create');
            Route::get('/getCoursesInfo/{id}','Admin\StudentsController@getCoursesInfo');
            Route::post('/store', 'Admin\StudentsController@store')->name('admin.students.store');
            Route::get('/{id}/view', 'Admin\StudentsController@show')->name('admin.students.view');
            Route::post('/search', 'Admin\StudentsController@search')->name('admin.students.search');
            Route::get('/{id}/edit', 'Admin\StudentsController@edit')->name('admin.students.edit');
            Route::post('/update', 'Admin\StudentsController@update')->name('admin.students.update');
            Route::get('/{id}/delete', 'Admin\StudentsController@delete')->name('admin.students.delete');

        });
        Route::group(['prefix'  =>   'fees'], function() {

            Route::get('/', 'Admin\StudentsController@payments')->name('admin.fees.index');
            Route::get('/feelog', 'Admin\FeesTransectionsController@index')->name('admin.fees.feelog');
            Route::get('/{id}/create', 'Admin\FeesTransectionsController@create')->name('admin.fees.create');
            // Route::get('/getCoursesInfo/{id}','Admin\StudentsController@getCoursesInfo');
            Route::post('/store', 'Admin\FeesTransectionsController@store')->name('admin.fees.store');
            Route::get('/{id}/view', 'Admin\FeesTransectionsController@show')->name('admin.fees.view');
            Route::get('/{id}/edit', 'Admin\FeesTransectionsController@edit')->name('admin.fees.edit');
            Route::post('/update', 'Admin\FeesTransectionsController@update')->name('admin.fees.update');
            // Route::get('/{id}/delete', 'Admin\StudentsController@delete')->name('admin.students.delete');

        });

        Route::group(['prefix'  =>   'session'], function() {

            Route::get('/', 'Admin\SessionController@index')->name('admin.session.index');
            Route::get('/create', 'Admin\SessionController@create')->name('admin.session.create');
            Route::post('/store', 'Admin\SessionController@store')->name('admin.session.store');
            Route::get('/{id}/view', 'Admin\SessionController@show')->name('admin.session.view');
            Route::get('/{id}/edit', 'Admin\SessionController@edit')->name('admin.session.edit');
            Route::post('/update', 'Admin\SessionController@update')->name('admin.session.update');
            Route::get('/{id}/delete', 'Admin\SessionController@delete')->name('admin.session.delete');

        });

    });
});