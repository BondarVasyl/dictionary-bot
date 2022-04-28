<?php

use Illuminate\Support\Facades\Route;

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
})->name('locale');

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.'
    ],
    function () {
        Route::group(
            [
                'middleware' => 'auth',
            ],
            function () {
                Route::get(
                    'user/new_password/{id}',
                    ['as' => 'user.new_password.get', 'uses' => 'UserController@getNewPassword']
                );
                Route::post(
                    'user/new_password/{id}',
                    ['as' => 'user.new_password.post', 'uses' => 'UserController@postNewPassword']
                );
                Route::resource('user', 'UserController', ['except' => 'delete']);
                Route::resource('permissions', 'PermissionsController');
                Route::resource('roles', 'RolesController');
                Route::post('user/{id}/ajax_field', 'UserController@ajaxFieldChange')
                    ->middleware('ajax')->name('user.ajax_field');

                // translations
                Route::get(
                    'translation/{group}',
                    ['as' => 'translation.index', 'uses' => 'TranslationController@index']
                );
                Route::post(
                    'translation/{group}',
                    ['as' => 'translation.update', 'uses' => 'TranslationController@update']
                );

                // variables
                Route::post(
                    'variable/{id}/ajax_field',
                    array (

                        'as'         => 'variable.ajax_field',
                        'uses'       => 'VariableController@ajaxFieldChange',
                    )
                );
                Route::get(
                    'variable/value/index',
                    ['as' => 'variable.value.index', 'uses' => 'VariableController@indexValues']
                );
                Route::post(
                    'variable/value/update',
                    [

                        'as'         => 'variable.value.update',
                        'uses'       => 'VariableController@updateValue',
                    ]
                );
                Route::resource('variable', 'VariableController');
            }
        );

        Route::resource('/settings', 'SettingController')->only('index', 'store');

        Route::group(
            [
                'prefix' => 'settings',
            ],
            function () {
                Route::post('set-webhook', 'SettingController@setWebhook')->name('settings.setWebhook');
                Route::post('get-webhook-info', 'SettingController@getWebhookInfo')->name('settings.getWebhookInfo');
                Route::post('delete-webhook', 'SettingController@deleteWebhook')->name('settings.deleteWebhook');
            }
        );

        Route::get('login', 'AuthController@showLoginForm')->name('login');
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout')->name('logout');
        Route::get('/', 'HomeController@index')->name('home');
    }
);
