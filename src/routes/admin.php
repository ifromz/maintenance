<?php

/*
 * Administration Routes
 */

Route::get('/', array(
    'as' => 'maintenance.admin.dashboard.index',
    'uses' => 'DashboardController@getIndex'
));

/*
 * Log Management Routes
 */
Route::post('logs/{logs}/mark-read', array(
    'as' => 'maintenance.admin.logs.mark-read',
    'uses' => 'LogController@markRead'
));

Route::resource('logs', 'LogController', array(
    'only' => array(
        'index',
        'show',
        'destroy',
    ),
    'names' => array(
        'index' => 'maintenance.admin.logs.index',
        'show' => 'maintenance.admin.logs.show',
        'destroy' => 'maintenance.admin.logs.destroy',
    ),
));
/*
 * End Log Management Routes
 */

/*
 * User Management Routes
 */
Route::group(array('namespace' => 'User'), function ()
{
    Route::resource('users', 'UserController', array(
        'names' => array(
            'index' => 'maintenance.admin.users.index',
            'create' => 'maintenance.admin.users.create',
            'store' => 'maintenance.admin.users.store',
            'show' => 'maintenance.admin.users.show',
            'edit' => 'maintenance.admin.users.edit',
            'update' => 'maintenance.admin.users.update',
            'destroy' => 'maintenance.admin.users.destroy',
        ),
    ));

    Route::patch('users/{users}/password', array(
        'as' => 'maintenance.admin.users.password.update',
        'uses' => 'PasswordController@update'
    ));

    Route::post('users/{users}/check-access', array(
        'as' => 'maintenance.admin.users.check-access',
        'uses' => 'AccessController@postCheck'
    ));
});
/*
 * End User Management Routes
 */

/*
 * Group Management Routes
 */
Route::resource('groups', 'GroupController', array(
    'names' => array(
        'index' => 'maintenance.admin.groups.index',
        'create' => 'maintenance.admin.groups.create',
        'store' => 'maintenance.admin.groups.store',
        'show' => 'maintenance.admin.groups.show',
        'edit' => 'maintenance.admin.groups.edit',
        'update' => 'maintenance.admin.groups.update',
        'destroy' => 'maintenance.admin.groups.destroy',
    )
));

/*
 * Archive Routes
 */
Route::group(array('namespace' => 'Archive'), function () {

    Route::get('archive', array(
        'as' => 'maintenance.admin.archive.index',
        'uses' => 'ArchiveController@getIndex'
    ));

    /*
     * Asset Archive Routes
     */
    Route::post('archive/assets/{assets}/restore', array(
        'as' => 'maintenance.admin.archive.assets.restore',
        'uses' => 'AssetController@restore'
    ));

    Route::resource('archive/assets', 'AssetController', array(
        'only' => array(
            'index',
            'show',
            'destroy',
        ),
        'names' => array(
            'index' => 'maintenance.admin.archive.assets.index',
            'show' => 'maintenance.admin.archive.assets.show',
            'destroy' => 'maintenance.admin.archive.assets.destroy',
        ),
    ));

    /*
     * Work Order Archive Routes
     */
    Route::post('archive/work-orders/{work_orders}/restore', array(
        'as' => 'maintenance.admin.archive.work-orders.restore',
        'uses' => 'WorkOrderController@restore'
    ));

    Route::resource('archive/work-orders', 'WorkOrderController', array(
        'only' => array(
            'index',
            'show',
            'destroy',
        ),
        'names' => array(
            'index' => 'maintenance.admin.archive.work-orders.index',
            'show' => 'maintenance.admin.archive.work-orders.show',
            'destroy' => 'maintenance.admin.archive.work-orders.destroy',
        ),
    ));

    /*
     * Inventory Archive Routes
     */
    Route::post('archive/inventory/{inventory}/restore', array(
        'as' => 'maintenance.admin.archive.inventory.restore',
        'uses' => 'InventoryController@restore'
    ));

    Route::resource('archive/inventory', 'InventoryController', array(
        'only' => array(
            'index',
            'show',
            'destroy',
        ),
        'names' => array(
            'index' => 'maintenance.admin.archive.inventory.index',
            'show' => 'maintenance.admin.archive.inventory.show',
            'destroy' => 'maintenance.admin.archive.inventory.destroy',
        ),
    ));
});
/*
 * End Archive Routes
 */

/*
 * Setting Routes
 */
Route::group(array('namespace' => 'Setting'), function ()
{

    Route::resource('settings/mail', 'MailController', array(
        'only' => array(
            'index',
            'store',
        ),
        'names' => array(
            'index' => 'maintenance.admin.settings.mail.index',
            'store' => 'maintenance.admin.settings.mail.store',
        ),
    ));

    Route::resource('settings/site', 'SiteController', array(
        'only' => array(
            'index',
            'store',
        ),
        'names' => array(
            'index' => 'maintenance.admin.settings.site.index',
            'store' => 'maintenance.admin.settings.site.store',
        ),
    ));

    Route::resource('settings', 'SettingsController', array(
        'only' => array(
            'index',
        ),
        'names' => array(
            'index' => 'maintenance.admin.settings.index',
        ),
    ));
});
/*
 * End Setting Routes
 */