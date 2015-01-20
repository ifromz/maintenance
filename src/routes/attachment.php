<?php

/*
 * Attachment Routes
 */

Route::resource('attachments', 'AttachmentController',
    array(
        'only' => array(
            'destroy'
        ),
        'names' => array(
            'destroy' => 'maintenance.attachments.destroy',
        ),
    )
);

Route::delete('attachments/uploaded', array(
    'as' => 'maintenance.attachments.uploaded.destroy',
));