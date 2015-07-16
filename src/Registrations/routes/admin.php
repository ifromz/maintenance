<?php

use Illuminate\Support\Facades\Route;

// Administration Routes
Route::get('/', [
    'as' => 'admin.dashboard.index',
    'uses' => 'DashboardController@getIndex',
]);

// Log Management Routes
Route::post('logs/{logs}/mark-read', [
    'as' => 'admin.logs.mark-read',
    'uses' => 'LogController@markRead',
]);

Route::resource('logs', 'LogController', [
    'only' => [
        'index',
        'show',
        'destroy',
    ],
    'names' => [
        'index' => 'admin.logs.index',
        'show' => 'admin.logs.show',
        'destroy' => 'admin.logs.destroy',
    ],
]);
// End Log Management Routes

// User Management Routes
Route::group(['namespace' => 'User'], function ()
{
    Route::resource('users', 'UserController', [
        'names' => [
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ],
    ]);

    Route::patch('users/{users}/password', [
        'as' => 'admin.users.password.update',
        'uses' => 'PasswordController@update',
    ]);

    Route::post('users/{users}/check-access', [
        'as' => 'admin.users.check-access',
        'uses' => 'AccessController@postCheck',
    ]);
});
// End User Management Routes

// Group Management Routes
Route::resource('roles', 'RoleController', [
    'names' => [
        'index' => 'admin.roles.index',
        'create' => 'admin.roles.create',
        'store' => 'admin.roles.store',
        'show' => 'admin.roles.show',
        'edit' => 'admin.roles.edit',
        'update' => 'admin.roles.update',
        'destroy' => 'admin.roles.destroy',
    ],
]);

// Archive Routes
Route::group(['namespace' => 'Archive'], function ()
{
    // Asset Archive Routes
    Route::post('archive/assets/{assets}/restore', [
        'as' => 'admin.archive.assets.restore',
        'uses' => 'AssetController@restore',
    ]);

    Route::resource('archive/assets', 'AssetController', [
        'only' => [
            'index',
            'show',
            'destroy',
        ],
        'names' => [
            'index' => 'admin.archive.assets.index',
            'show' => 'admin.archive.assets.show',
            'destroy' => 'admin.archive.assets.destroy',
        ],
    ]);

    // Work Order Archive Routes
    Route::post('archive/work-orders/{work_orders}/restore', [
        'as' => 'admin.archive.work-orders.restore',
        'uses' => 'WorkOrderController@restore',
    ]);

    Route::resource('archive/work-orders', 'WorkOrderController', [
        'only' => [
            'index',
            'show',
            'destroy',
        ],
        'names' => [
            'index' => 'admin.archive.work-orders.index',
            'show' => 'admin.archive.work-orders.show',
            'destroy' => 'admin.archive.work-orders.destroy',
        ],
    ]);

    // Inventory Archive Routes
    Route::post('archive/inventory/{inventory}/restore', [
        'as' => 'admin.archive.inventory.restore',
        'uses' => 'InventoryController@restore',
    ]);

    Route::resource('archive/inventory', 'InventoryController', [
        'only' => [
            'index',
            'show',
            'destroy',
        ],
        'names' => [
            'index' => 'admin.archive.inventory.index',
            'show' => 'admin.archive.inventory.show',
            'destroy' => 'admin.archive.inventory.destroy',
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
            'index' => 'admin.settings.site.index',
            'store' => 'admin.settings.site.store',
        ],
    ]);
});
// End Setting Routes
