<?php

/*
 * Amdministration Routes
 */

Route::get('/', array(
    'as'    => 'maintenance.admin.dashboard.index',
    'uses'  => 'DashboardController@getIndex'
));

/*
 * User Management Routes
 */
Route::resource('users', 'UserController', array(
    'names' => array(
        'index'     => 'maintenance.admin.users.index',
        'create'    => 'maintenance.admin.users.create',
        'store'     => 'maintenance.admin.users.store',
        'show'      => 'maintenance.admin.users.show',
        'edit'      => 'maintenance.admin.users.edit',
        'update'    => 'maintenance.admin.users.update',
        'destroy'   => 'maintenance.admin.users.destroy',
    ),
));

Route::post('users/{users}/check-access', array(
    'as' => 'maintenance.admin.users.check-access',
    'uses' => 'AccessController@postCheck'
));

/*
 * Group Management Routes
 */
Route::resource('groups', 'GroupController', array(
    'names'=>array(
        'index'     => 'maintenance.admin.groups.index',
        'create'    => 'maintenance.admin.groups.create',
        'store'     => 'maintenance.admin.groups.store',
        'show'      => 'maintenance.admin.groups.show',
        'edit'      => 'maintenance.admin.groups.edit',
        'update'    => 'maintenance.admin.groups.update',
        'destroy'   => 'maintenance.admin.groups.destroy',
    )
));

/*
 * Archive Routes
 */
Route::get('archive', array(
    'as'    => 'maintenance.admin.archive.index',
    'uses'  => 'ArchiveController@getIndex'
));

/*
 * Asset Archive Routes
 */
Route::post('archive/assets/{assets}/restore', array(
    'as'    => 'maintenance.admin.archive.assets.restore',
    'uses'  => 'ArchiveAssetController@restore'
));

Route::resource('archive/assets', 'ArchiveAssetController',  array(
    'only' => array(
        'index',
        'show',
        'destroy',
    ),
    'names' => array(
        'index'     => 'maintenance.admin.archive.assets.index',
        'show'      => 'maintenance.admin.archive.assets.show',
        'destroy'   => 'maintenance.admin.archive.assets.destroy',
    ),
));

/*
 * Work Order Archive Routes
 */
Route::post('archive/work-orders/{work_orders}/restore', array(
    'as'    => 'maintenance.admin.archive.work-orders.restore',
    'uses'  => 'ArchiveWorkOrderController@restore'
));

Route::resource('archive/work-orders', 'ArchiveWorkOrderController',  array(
    'only' => array(
        'index',
        'show',
        'destroy',
    ),
    'names' => array(
        'index'     => 'maintenance.admin.archive.work-orders.index',
        'show'      => 'maintenance.admin.archive.work-orders.show',
        'destroy'   => 'maintenance.admin.archive.work-orders.destroy',
    ),
));

/*
 * Inventory Archive Routes
 */
Route::post('archive/inventory/{inventory}/restore', array(
    'as'    => 'maintenance.admin.archive.inventory.restore',
    'uses'  => 'ArchiveInventoryController@restore'
));

Route::resource('archive/inventory', 'ArchiveInventoryController',  array(
    'only' => array(
        'index',
        'show',
        'destroy',
    ),
    'names' => array(
        'index'     => 'maintenance.admin.archive.inventory.index',
        'show'      => 'maintenance.admin.archive.inventory.show',
        'destroy'   => 'maintenance.admin.archive.inventory.destroy',
    ),
));