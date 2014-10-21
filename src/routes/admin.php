<?php

/*
 * Amdministration Routes
 */

Route::get('/', array(
    'as' => 'maintenance.admin.dashboard.index',
    'uses'=> 'DashboardController@getIndex'
));

Route::resource('users', 'UserController', array(
    'names' => array(
        'index'     => 'maintenance.admin.users.index',
        'create'    => 'maintenance.admin.users.create',
        'store'   	=> 'maintenance.admin.users.store',
        'show'    	=> 'maintenance.admin.users.show',
        'edit'    	=> 'maintenance.admin.users.edit',
        'update'  	=> 'maintenance.admin.users.update',
        'destroy' 	=> 'maintenance.admin.users.destroy',
    ),
));

Route::resource('groups', 'GroupController', array(
    'names'=>array(
        'index'     => 'maintenance.admin.groups.index',
        'create'    => 'maintenance.admin.groups.create',
        'store'   	=> 'maintenance.admin.groups.store',
        'show'    	=> 'maintenance.admin.groups.show',
        'edit'    	=> 'maintenance.admin.groups.edit',
        'update'  	=> 'maintenance.admin.groups.update',
        'destroy' 	=> 'maintenance.admin.groups.destroy',
    )
));

Route::post('users/{users}/check-access', array(
    'as' => 'maintenance.admin.users.check-access',
    'uses' => 'AccessController@postCheck'
));

Route::get('archive', array(
    'as' => 'maintenance.admin.archive.index',
    'uses' => 'ArchiveController@getIndex'
));

Route::post('archive/assets/{assets}/restore', array(
    'as' => 'maintenance.admin.archive.assets.restore',
    'uses' => 'ArchiveAssetController@restore'
));

Route::resource('archive/assets', 'ArchiveAssetController',  array(
    'names' => array(
        'index'     => 'maintenance.admin.archive.assets.index',
        'show'    	=> 'maintenance.admin.archive.assets.show',
        'destroy' 	=> 'maintenance.admin.archive.assets.destroy',
    ),
));