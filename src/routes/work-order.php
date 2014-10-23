<?php

/*
 * Work Order Routes
 */

Route::resource('work-orders/priorities', 'PriorityController', array(
    'only' => array(
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ),
    'names'=> array(
        'index'         => 'maintenance.work-orders.priorities.index',
        'create'  	=> 'maintenance.work-orders.priorities.create',
        'store'   	=> 'maintenance.work-orders.priorities.store',
        'show'    	=> 'maintenance.work-orders.priorities.show',
        'edit'    	=> 'maintenance.work-orders.priorities.edit',
        'update'  	=> 'maintenance.work-orders.priorities.update',
        'destroy' 	=> 'maintenance.work-orders.priorities.destroy',
    ),
));

Route::resource('work-orders/statuses', 'StatusController', array(
    'only' => array(
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ),
    'names'=> array(
        'index'         => 'maintenance.work-orders.statuses.index',
        'create'  	=> 'maintenance.work-orders.statuses.create',
        'store'   	=> 'maintenance.work-orders.statuses.store',
        'show'    	=> 'maintenance.work-orders.statuses.show',
        'edit'    	=> 'maintenance.work-orders.statuses.edit',
        'update'  	=> 'maintenance.work-orders.statuses.update',
        'destroy' 	=> 'maintenance.work-orders.statuses.destroy',
    ),
));

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