<?php



/*
|--------------------------------------------------------------------------
| Maintenance Routes
|--------------------------------------------------------------------------
*/
Route::group(array('prefix'=>Config::get('maintenance::prefix')), function(){
    
	/*
        |--------------------------------------------------------------------------
        | Maintenance Public Routes
        |--------------------------------------------------------------------------
        */
        Route::group(array('prefix'=>'register', 'namespace'=>'Stevebauman\Maintenance\Controllers'), function(){
            Route::get('', array(
                'as' => 'maintenance.register',
                'uses' => 'AuthController@getRegister',
            ));
            
            Route::get('why', array(
                'as' => 'maintenance.register.why',
                'uses' => 'AuthController@getWhyRegister',
            ));
            
            Route::post('', array(
                'as' => 'maintenance.register',
                'uses' => 'AuthController@postRegister',
            ));
        });
    
	Route::group(array('prefix'=>'login', 'namespace'=>'Stevebauman\Maintenance\Controllers', 'before'=>'maintenance.notauth'), function(){
	
		Route::get('', array(
			'as' => 'maintenance.login',
			'uses'=>'AuthController@getLogin',
		));
		
		Route::post('', array(
			'as' => 'maintenance.login',
			'uses'=>'AuthController@postLogin',
		));
	
	});
        
        Route::group(array('namespace'=>'Stevebauman\Maintenance\Controllers', 'before'=>'maintenance.auth'), function(){
            
            Route::get('logout', array(
                    'as' => 'maintenance.logout',
                    'uses'=>'AuthController@getLogout',
            ));
            
        });
        
        /* End Maintenance Authentication Routes */
	
        
        
        Route::get('permission-denied', array(
            'as'=>'maintenance.permission-denied.index',
            'uses'=>'Stevebauman\Maintenance\Controllers\PermissionDeniedController@getIndex'
        ));
	
	/*
	|--------------------------------------------------------------------------
	| Maintenance Controller Routes
	|--------------------------------------------------------------------------
	*/	
	Route::group(array('namespace'=>'Stevebauman\Maintenance\Controllers', 'before'=>'maintenance.auth|maintenance.permission'), function(){
		
		Route::get('/', array(
			'as' => 'maintenance.dashboard.index',
			'uses'=>'MaintenanceController@getIndex',
		));
		
		/*
		|--------------------------------------------------------------------------
		| Maintenance Work Order Category Routes
		|--------------------------------------------------------------------------
		*/
		Route::get('work-orders/categories/json', array(
				'as' => 'maintenance.work-orders.categories.json',
				'uses' => 'WorkOrderCategoryController@getJson',
			)
		);
		
		Route::get('work-orders/categories/create/{categories?}', array(
				'as' => 'maintenance.work-orders.categories.nodes.create',
				'uses' => 'WorkOrderCategoryController@create',
			)
		);
		
		Route::post('work-orders/categories/move/{categories?}', array(
			'as' => 'maintenance.work-orders.categories.nodes.move',
			'uses'=> 'WorkOrderCategoryController@postMoveCategory'
		));
		
		Route::post('work-orders/categories/create/{categories?}', array(
				'as' => 'maintenance.work-orders.categories.nodes.store',
				'uses' => 'WorkOrderCategoryController@store',
			)
		);
		
		Route::resource('work-orders/categories', 'WorkOrderCategoryController', array(
			'names'=> array(
				'index'		=> 'maintenance.work-orders.categories.index',
				'create'  	=> 'maintenance.work-orders.categories.create',
				'store'   	=> 'maintenance.work-orders.categories.store',
				'show'    	=> 'maintenance.work-orders.categories.show',
				'edit'    	=> 'maintenance.work-orders.categories.edit',
				'update'  	=> 'maintenance.work-orders.categories.update',
				'destroy' 	=> 'maintenance.work-orders.categories.destroy',
			),
		));
                
		
		/*
		|--------------------------------------------------------------------------
		| Maintenance Work Order Routes
		|--------------------------------------------------------------------------
		*/
                Route::post('work-orders/{work_orders}/start-session', array(
                    'as' => 'maintenance.work-orders.session.start',
                    'uses' => 'WorkOrderSessionController@postStart'
                ));
                
                Route::post('work-orders/{work_orders}/end-session/{session}', array(
                    'as' => 'maintenance.work-orders.session.end',
                    'uses' => 'WorkOrderSessionController@postEnd'
                ));
                
                /*
		|--------------------------------------------------------------------------
		| Maintenance Work Order Report Routes
		|--------------------------------------------------------------------------
		*/
                Route::resource('work-orders/{work_orders}/report', 'WorkOrderReportController', array(
                    'only' => array(
                        'create',
                        'store',
                        'show', 
                        'edit',  
                        'update', 
                        'destroy',
                    ),
                    'names'=> array(
                        'create'        => 'maintenance.work-orders.report.create',
                        'store'   	=> 'maintenance.work-orders.report.store',
                        'show'    	=> 'maintenance.work-orders.report.show',
                        'edit'    	=> 'maintenance.work-orders.report.edit',
                        'update'  	=> 'maintenance.work-orders.report.update',
                        'destroy' 	=> 'maintenance.work-orders.report.destroy',
                    ),
		));
                
                
                /*
		|--------------------------------------------------------------------------
		| Maintenance Work Order Routes
		|--------------------------------------------------------------------------
		*/
		Route::resource('work-orders', 'WorkOrderController', array(
                    'names'=> array(
                        'index'         => 'maintenance.work-orders.index',
                        'create'  	=> 'maintenance.work-orders.create',
                        'store'   	=> 'maintenance.work-orders.store',
                        'show'    	=> 'maintenance.work-orders.show',
                        'edit'    	=> 'maintenance.work-orders.edit',
                        'update'  	=> 'maintenance.work-orders.update',
                        'destroy' 	=> 'maintenance.work-orders.destroy',
                    ),
		));
		
		
		/*
		|--------------------------------------------------------------------------
		| Maintenance Work Order Update Routes
		|--------------------------------------------------------------------------
		*/	
		Route::resource('work-orders.updates', 'WorkOrderUpdateController', array(
			'names'=> array(
				'index'		=> 'maintenance.work-orders.updates.index',
				'create'  	=> 'maintenance.work-orders.updates.create',
				'store'   	=> 'maintenance.work-orders.updates.store',
				'show'    	=> 'maintenance.work-orders.updates.show',
				'edit'    	=> 'maintenance.work-orders.updates.edit',
				'update'  	=> 'maintenance.work-orders.updates.update',
				'destroy' 	=> 'maintenance.work-orders.updates.destroy',
			),
		));
		
                /*
		|--------------------------------------------------------------------------
		| Maintenance Work Order Assignment Routes
		|--------------------------------------------------------------------------
		*/
                Route::resource('work-orders.assignments', 'WorkOrderAssignmentController', array(
                    'only' => array(
                        'index',
                        'create',
                        'store',
                        'destroy'
                    ),
                    'names' => array(
                        'index' => 'maintenance.work-orders.assignments.index',
                        'create' => 'maintenance.work-orders.assignments.create',
                        'store' => 'maintenance.work-orders.assignments.store',
                        'destroy' => 'maintenance.work-orders.assignments.destroy'
                    ),
                ));
                
                /*
		|--------------------------------------------------------------------------
		| Maintenance Work Order Part / Supply Routes
		|--------------------------------------------------------------------------
		*/
                Route::resource('work-orders.parts', 'WorkOrderPartController', array(
                    'only' => array(
                        'index',
                        'destroy',
                    ),
                    'names' => array(
                        'index' => 'maintenance.work-orders.parts.index',
                        'destroy' => 'maintenance.work-orders.parts.destroy'
                    ),
                ));
                
                Route::get('work-orders/{work_orders}/parts/{inventory}/stocks', array(
                    'as' => 'maintenance.work-orders.parts.stocks.index',
                    'uses' => 'WorkOrderPartStockController@getIndex'
                ));
                
                
                Route::get('work-orders/{work_orders}/parts/{inventory}/stocks/{stocks}/add', array(
                    'as' => 'maintenance.work-orders.parts.stocks.add',
                    'uses' => 'WorkOrderPartStockController@getAdd'
                ));
                
                Route::post('work-orders/{work_orders}/parts/{inventory}/stocks/{stocks}', array(
                    'as' => 'maintenance.work-orders.parts.stocks.store',
                    'uses' => 'WorkOrderPartStockController@postStore'
                ));
                
                Route::post('work-orders/{work_orders}/parts/{inventory}/stocks/{stocks}/remove', array(
                    'as' => 'maintenance.work-orders.parts.stocks.destroy',
                    'uses' => 'WorkOrderPartStockController@postDestroy'
                ));
                
                /*
                 * Work Order Attachment Upload Routes
                 */
		Route::post('work-orders/attachmemnts/uploads', array(
			'as' => 'maintenance.work-orders.attachments.uploads.store',
			'uses' => 'WorkOrderAttachmentUploadController@store'
		));
		
		Route::post('work-orders/attachmemnts/uploads/destroy', array(
			'as' => 'maintenance.work-orders.attachments.uploads.destroy',
			'uses' => 'WorkOrderAttachmentUploadController@store@destroy'
		));
                
                Route::resource('work-orders.attachments', 'WorkOrderAttachmentController', array(
                    'only' => array(
                        'index',	
                        'create', 
                        'store',
                        'show', 
                        'destroy'
                    ),
                    'names' => array(
                        'index'		=> 'maintenance.work-orders.attachments.index',
                        'create'  	=> 'maintenance.work-orders.attachments.create',
                        'store'   	=> 'maintenance.work-orders.attachments.store',
                        'show'    	=> 'maintenance.work-orders.attachments.show',
                        'destroy' 	=> 'maintenance.work-orders.attachments.destroy',
                    )
                ));
                
                /*
                 * Asset Image Upload Routes
                 */
		Route::post('assets/images/uploads', array(
			'as' => 'maintenance.assets.images.uploads.store',
			'uses' => 'AssetImageUploadController@store'
		));
		
		Route::post('assets/images/uploads/destroy', array(
			'as' => 'maintenance.assets.images.uploads.destroy',
			'uses' => 'AssetImageUploadController@destroy'
		));
                
                Route::resource('assets.images', 'AssetImageController', array(
                        'only' => array(
                            'index',	
                            'create', 
                            'store',
                            'show', 
                            'destroy'
                        ),
			'names'=> array(
				'index'		=> 'maintenance.assets.images.index',
				'create'  	=> 'maintenance.assets.images.create',
				'store'   	=> 'maintenance.assets.images.store',
				'show'    	=> 'maintenance.assets.images.show',
				'destroy' 	=> 'maintenance.assets.images.destroy',
			),
		));
		
                /*
                 * End Asset Image Upload Routes
                 */
                
                /*
                 * Asset Manual Upload Routes
                 */
                Route::post('assets/manuals/uploads', array(
			'as' => 'maintenance.assets.manuals.uploads.store',
			'uses' => 'AssetManualUploadController@store'
		));
		
		Route::post('assets/manuals/uploads/destroy', array(
			'as' => 'maintenance.assets.manuals.uploads.destroy',
			'uses' => 'AssetManualUploadController@destroy'
		));
                
                Route::resource('assets.manuals', 'AssetManualController', array(
                        'only' => array(
                            'index',
                            'create',
                            'store',
                            'destroy'
                        ),
			'names'=> array(
				'index'		=> 'maintenance.assets.manuals.index',
				'create'  	=> 'maintenance.assets.manuals.create',
				'store'   	=> 'maintenance.assets.manuals.store',
				'destroy' 	=> 'maintenance.assets.manuals.destroy',
			),
		));
                /*
                 * End Asset Manual Upload Routes
                 */
		
                Route::resource('assets.events', 'AssetEventController', array(
                    'names' => array(
                                'index'		=> 'maintenance.assets.events.index',
				'create'  	=> 'maintenance.assets.events.create',
				'store'   	=> 'maintenance.assets.events.store',
				'show'    	=> 'maintenance.assets.events.show',
				'edit'    	=> 'maintenance.assets.events.edit',
				'update'  	=> 'maintenance.assets.events.update',
				'destroy' 	=> 'maintenance.assets.events.destroy',
                    )
                ));
                
                /*
                 * Asset Routes
                 */
                Route::resource('assets', 'AssetController', array(
			'names'=> array(
				'index'		=> 'maintenance.assets.index',
				'create'  	=> 'maintenance.assets.create',
				'store'   	=> 'maintenance.assets.store',
				'show'    	=> 'maintenance.assets.show',
				'edit'    	=> 'maintenance.assets.edit',
				'update'  	=> 'maintenance.assets.update',
				'destroy' 	=> 'maintenance.assets.destroy',
			),
		));
                /*
                 * End Asset Routes
                 */
                
                Route::resource('inventory', 'InventoryController', array(
			'names'=> array(
				'index'		=> 'maintenance.inventory.index',
				'create'  	=> 'maintenance.inventory.create',
				'store'   	=> 'maintenance.inventory.store',
				'show'    	=> 'maintenance.inventory.show',
				'edit'    	=> 'maintenance.inventory.edit',
				'update'  	=> 'maintenance.inventory.update',
				'destroy' 	=> 'maintenance.inventory.destroy',
			),
		));
                
                Route::resource('inventory.stocks', 'InventoryStockController', array(
			'names'=> array(
				'index'		=> 'maintenance.inventory.stocks.index',
				'create'  	=> 'maintenance.inventory.stocks.create',
				'store'   	=> 'maintenance.inventory.stocks.store',
				'show'    	=> 'maintenance.inventory.stocks.show',
				'edit'    	=> 'maintenance.inventory.stocks.edit',
				'update'  	=> 'maintenance.inventory.stocks.update',
				'destroy' 	=> 'maintenance.inventory.stocks.destroy',
			),
		));
                
                
                Route::resource('inventory.stocks.movements', 'InventoryStockMovementController', array(
                        'only' => array(
                            'index'
                        ),
			'names'=> array(
				'index'		=> 'maintenance.inventory.stocks.movements.index',
			),
		));
                
                /*
                 * Global Attachment Routes
                 */
		Route::resource('attachments', 'AttachmentController', 
			array(
                            'only' => array(
                                    'destroy'
                            ),
                            'names' => array(
                                    'destroy' => 'maintenace.attachments.destroy',
                            ),
			)
		);
		/*
                 * End Global Attachment Routes
                 */
		
		
		/*
		|--------------------------------------------------------------------------
		| Maintenance Location Routes
		|--------------------------------------------------------------------------
		*/
		Route::get('locations/json', array(
				'as' => 'maintenance.locations.json',
				'uses' => 'LocationController@getJson',
			)
		);
		
		Route::get('locations/create/{categories?}', array(
				'as' => 'maintenance.locations.nodes.create',
				'uses' => 'LocationController@create',
			)
		);
		
		Route::post('locations/move/{categories?}', array(
			'as' => 'maintenance.locations.nodes.move',
			'uses'=> 'LocationController@postMoveCategory'
		));
		
		Route::post('locations/create/{categories?}', array(
				'as' => 'maintenance.locations.nodes.store',
				'uses' => 'LocationController@store',
			)
		);
		
		Route::resource('locations', 'LocationController', array(
			'names'=> array(
				'index'		=> 'maintenance.locations.index',
				'create'  	=> 'maintenance.locations.create',
				'store'   	=> 'maintenance.locations.store',
				'show'    	=> 'maintenance.locations.show',
				'edit'    	=> 'maintenance.locations.edit',
				'update'  	=> 'maintenance.locations.update',
				'destroy' 	=> 'maintenance.locations.destroy',
			),
		));
		
                
                /*
		|--------------------------------------------------------------------------
		| Maintenance Category Routes
		|--------------------------------------------------------------------------
		*/
		Route::get('categories/json', array(
				'as' => 'maintenance.categories.json',
				'uses' => 'CategoryController@getJson',
			)
		);
		
		Route::get('categories/create/{categories?}', array(
				'as' => 'maintenance.categories.nodes.create',
				'uses' => 'CategoryController@create',
			)
		);
		
		Route::post('categories/move/{categories?}', array(
			'as' => 'maintenance.categories.nodes.move',
			'uses'=> 'CategoryController@postMoveCategory'
		));
		
		Route::post('categories/create/{categories?}', array(
				'as' => 'maintenance.categories.nodes.store',
				'uses' => 'CategoryController@store',
			)
		);
		
		Route::resource('categories', 'CategoryController', array(
			'names'=> array(
				'index'		=> 'maintenance.categories.index',
				'create'  	=> 'maintenance.categories.create',
				'store'   	=> 'maintenance.categories.store',
				'show'    	=> 'maintenance.categories.show',
				'edit'    	=> 'maintenance.categories.edit',
				'update'  	=> 'maintenance.categories.update',
				'destroy' 	=> 'maintenance.categories.destroy',
			),
		));
		
                /*
                |--------------------------------------------------------------------------
                | Maintenance Administration Routes
                |--------------------------------------------------------------------------
                */
                Route::group(array('prefix'=>'admin'), function(){
                    
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
                });
                
	}); /* End Maintenance Controller Routes */

	
	/*
	|--------------------------------------------------------------------------
	| Maintenance JSON API Routes
	|--------------------------------------------------------------------------
	*/
	Route::group(array('prefix'=>'api', 'namespace'=>'Stevebauman\Maintenance\Apis'), function(){
            
            Route::group(array('prefix'=>'v1', 'namespace'=>'v1'), function(){
                
                Route::group(array('prefix'=>'assets'), function(){
                   
                    Route::get('', array(
                        'as'=>'maintenance.api.v1.assets.get',
                        'uses'=>'AssetApi@get'
                    ));
                    
                    Route::get('find/{assets}', array(
                        'as'=>'maintenance.api.v1.assets.find',
                        'uses'=>'AssetApi@find'
                    ));
                    
                });
                
            });
            
            Route::group(array('prefix'=>'notifications'), function(){
                
                Route::resource('notifications', 'NotificationApi', array(
                    'only' => array('update'),
                    'names' => array(
                        'update' => 'maintenance.api.notifications.update'
                    ),
                ));
                
            });
		
		/*
		|--------------------------------------------------------------------------
		| Maintenance Work Order Api Routes
		|--------------------------------------------------------------------------
		*/
		Route::group(array('prefix'=>'work-orders'), function(){
			Route::get('', array('as'=>'maintenance.api.work-orders.get', 'uses'=>'AssetApi@get'));
			
			Route::get('{work_orders}', array('as'=>'maintenance.api.work-orders.find', 'uses'=>'AssetApi@find'));
		});
	
		/*
		|--------------------------------------------------------------------------
		| Maintenance Asset Api Routes
		|--------------------------------------------------------------------------
		*/
                Route::group(array('prefix'=>'assets'), function(){
			Route::get('', array('as'=>'maintenance.api.assets.get', 'uses'=>'AssetApi@get'));
                        Route::get('q', array('as'=>'maintenance.api.assets.query', 'uses'=>'AssetApi@getByQuery'));
                        Route::get('makes', array('as'=>'maintenance.api.assets.makes', 'uses'=>'AssetApi@getMakes'));
			Route::get('models', array('as'=>'maintenance.api.assets.models', 'uses'=>'AssetApi@getModels'));
			Route::get('serials', array('as'=>'maintenance.api.assets.serials', 'uses'=>'AssetApi@getSerials'));
		});
                
                Route::resource('inventory.stocks', 'InventoryStockApi', array(
                    'only' => array(
                        'edit',
                        'update'
                    ),
                    'names' => array(
                        'edit'    	=> 'maintenance.api.inventory.stocks.edit',
                        'update'  	=> 'maintenance.api.inventory.stocks.update',
                    ),
                ));
                
                /*
		|--------------------------------------------------------------------------
		| Maintenance Calendar Api Routes
		|--------------------------------------------------------------------------
		*/
                Route::group(array('prefix'=>'calendar'), function(){
                    
                    Route::resource('events', 'EventApi', array(
			'names'=> array(
				'index'		=> 'maintenance.api.calendar.events.index',
				'create'  	=> 'maintenance.api.calendar.events.create',
				'store'   	=> 'maintenance.api.calendar.events.store',
				'show'    	=> 'maintenance.api.calendar.events.show',
				'edit'    	=> 'maintenance.api.calendar.events.edit',
				'update'  	=> 'maintenance.api.calendar.events.update',
				'destroy' 	=> 'maintenance.api.calendar.events.destroy',
			),
                    ));
                    
                    Route::resource('events/assets', 'AssetEventApi', array(
                        'only' => array(
                            'index',
                            'show',
                        ),
			'names'=> array(
				'index' => 'maintenance.api.calendar.events.assets.index',
                                'show' => 'maintenance.api.calendar.events.assets.show',
			),
                    ));
                    
                });
	}); /* End Maintenance API Routes */
	
	
	
}); /* End Maintenance Routes */