<?php

use Illuminate\Support\Facades\Route;

// Administration Routes
Route::get('/', [
    'as' => 'maintenance.admin.dashboard.index',
    'uses' => 'DashboardController@getIndex',
]);

// Log Management Routes
Route::post('logs/{logs}/mark-read', [
    'as' => 'maintenance.admin.logs.mark-read',
    'uses' => 'LogController@markRead',
]);

Route::resource('logs', 'LogController', [
    'only' => [
        'index',
        'show',
        'destroy',
    ],
    'names' => [
        'index' => 'maintenance.admin.logs.index',
        'show' => 'maintenance.admin.logs.show',
        'destroy' => 'maintenance.admin.logs.destroy',
    ],
]);
// End Log Management Routes

// User Management Routes
Route::group(['namespace' => 'User'], function ()
{
    Route::resource('users', 'UserController', [
        'names' => [
            'index' => 'maintenance.admin.users.index',
            'create' => 'maintenance.admin.users.create',
            'store' => 'maintenance.admin.users.store',
            'show' => 'maintenance.admin.users.show',
            'edit' => 'maintenance.admin.users.edit',
            'update' => 'maintenance.admin.users.update',
            'destroy' => 'maintenance.admin.users.destroy',
        ],
    ]);

    Route::patch('users/{users}/password', [
        'as' => 'maintenance.admin.users.password.update',
        'uses' => 'PasswordController@update',
    ]);

    Route::post('users/{users}/check-access', [
        'as' => 'maintenance.admin.users.check-access',
        'uses' => 'AccessController@postCheck',
    ]);
});
// End User Management Routes

// Group Management Routes
Route::resource('groups', 'GroupController', [
    'names' => [
        'index' => 'maintenance.admin.groups.index',
        'create' => 'maintenance.admin.groups.create',
        'store' => 'maintenance.admin.groups.store',
        'show' => 'maintenance.admin.groups.show',
        'edit' => 'maintenance.admin.groups.edit',
        'update' => 'maintenance.admin.groups.update',
        'destroy' => 'maintenance.admin.groups.destroy',
    ],
]);

// Archive Routes
Route::group(['namespace' => 'Archive'], function ()
{
    // Asset Archive Routes
    Route::post('archive/assets/{assets}/restore', [
        'as' => 'maintenance.admin.archive.assets.restore',
        'uses' => 'AssetController@restore',
    ]);

    Route::resource('archive/assets', 'AssetController', [
        'only' => [
            'index',
            'show',
            'destroy',
        ],
        'names' => [
            'index' => 'maintenance.admin.archive.assets.index',
            'show' => 'maintenance.admin.archive.assets.show',
            'destroy' => 'maintenance.admin.archive.assets.destroy',
        ],
    ]);

    // Work Order Archive Routes
    Route::post('archive/work-orders/{work_orders}/restore', [
        'as' => 'maintenance.admin.archive.work-orders.restore',
        'uses' => 'WorkOrderController@restore',
    ]);

    Route::resource('archive/work-orders', 'WorkOrderController', [
        'only' => [
            'index',
            'show',
            'destroy',
        ],
        'names' => [
            'index' => 'maintenance.admin.archive.work-orders.index',
            'show' => 'maintenance.admin.archive.work-orders.show',
            'destroy' => 'maintenance.admin.archive.work-orders.destroy',
        ],
    ]);

    // Inventory Archive Routes
    Route::post('archive/inventory/{inventory}/restore', [
        'as' => 'maintenance.admin.archive.inventory.restore',
        'uses' => 'InventoryController@restore',
    ]);

    Route::resource('archive/inventory', 'InventoryController', [
        'only' => [
            'index',
            'show',
            'destroy',
        ],
        'names' => [
            'index' => 'maintenance.admin.archive.inventory.index',
            'show' => 'maintenance.admin.archive.inventory.show',
            'destroy' => 'maintenance.admin.archive.inventory.destroy',
        ],
    ]);
});
// End Archive Routes

// Setting Routes
Route::group(['namespace' => 'Setting'], function ()
{
    Route::resource('settings/site', 'SiteController', [
        'only' => [
            'index',
            'store',
        ],
        'names' => [
            'index' => 'maintenance.admin.settings.site.index',
            'store' => 'maintenance.admin.settings.site.store',
        ],
    ]);
});
// End Setting Routes
