<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/company'], function (Router $router) {
    $router->bind('account', function ($id) {
        return app('Modules\Company\Repositories\AccountRepository')->find($id);
    });
    $router->get('accounts', [
        'as' => 'admin.company.account.index',
        'uses' => 'AccountController@index',
        'middleware' => 'can:company.accounts.index'
    ]);
    $router->get('accounts/create', [
        'as' => 'admin.company.account.create',
        'uses' => 'AccountController@create',
        'middleware' => 'can:company.accounts.create'
    ]);
    $router->post('accounts', [
        'as' => 'admin.company.account.store',
        'uses' => 'AccountController@store',
        'middleware' => 'can:company.accounts.create'
    ]);
    $router->get('accounts/{account}/edit', [
        'as' => 'admin.company.account.edit',
        'uses' => 'AccountController@edit',
        'middleware' => 'can:company.accounts.edit'
    ]);
    $router->put('accounts/{account}', [
        'as' => 'admin.company.account.update',
        'uses' => 'AccountController@update',
        'middleware' => 'can:company.accounts.edit'
    ]);
    $router->delete('accounts/{account}', [
        'as' => 'admin.company.account.destroy',
        'uses' => 'AccountController@destroy',
        'middleware' => 'can:company.accounts.destroy'
    ]);
    $router->bind('contact', function ($id) {
        return app('Modules\Company\Repositories\ContactRepository')->find($id);
    });
    $router->get('contacts', [
        'as' => 'admin.company.contact.index',
        'uses' => 'ContactController@index',
        'middleware' => 'can:company.contacts.index'
    ]);
    $router->get('contacts/create', [
        'as' => 'admin.company.contact.create',
        'uses' => 'ContactController@create',
        'middleware' => 'can:company.contacts.create'
    ]);
    $router->post('contacts', [
        'as' => 'admin.company.contact.store',
        'uses' => 'ContactController@store',
        'middleware' => 'can:company.contacts.create'
    ]);
    $router->get('contacts/{contact}/edit', [
        'as' => 'admin.company.contact.edit',
        'uses' => 'ContactController@edit',
        'middleware' => 'can:company.contacts.edit'
    ]);
    $router->put('contacts/{contact}', [
        'as' => 'admin.company.contact.update',
        'uses' => 'ContactController@update',
        'middleware' => 'can:company.contacts.edit'
    ]);
    $router->delete('contacts/{contact}', [
        'as' => 'admin.company.contact.destroy',
        'uses' => 'ContactController@destroy',
        'middleware' => 'can:company.contacts.destroy'
    ]);
    $router->bind('accounttype', function ($id) {
        return app('Modules\Company\Repositories\AccountTypeRepository')->find($id);
    });
    $router->get('accounttypes', [
        'as' => 'admin.company.accounttype.index',
        'uses' => 'AccountTypeController@index',
        'middleware' => 'can:company.accounttypes.index'
    ]);
    $router->get('accounttypes/create', [
        'as' => 'admin.company.accounttype.create',
        'uses' => 'AccountTypeController@create',
        'middleware' => 'can:company.accounttypes.create'
    ]);
    $router->post('accounttypes', [
        'as' => 'admin.company.accounttype.store',
        'uses' => 'AccountTypeController@store',
        'middleware' => 'can:company.accounttypes.create'
    ]);
    $router->get('accounttypes/{accounttype}/edit', [
        'as' => 'admin.company.accounttype.edit',
        'uses' => 'AccountTypeController@edit',
        'middleware' => 'can:company.accounttypes.edit'
    ]);
    $router->put('accounttypes/{accounttype}', [
        'as' => 'admin.company.accounttype.update',
        'uses' => 'AccountTypeController@update',
        'middleware' => 'can:company.accounttypes.edit'
    ]);
    $router->delete('accounttypes/{accounttype}', [
        'as' => 'admin.company.accounttype.destroy',
        'uses' => 'AccountTypeController@destroy',
        'middleware' => 'can:company.accounttypes.destroy'
    ]);
// append



});
