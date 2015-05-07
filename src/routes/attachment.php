<?php

/*
 * Attachment Routes
 */

Route::resource('attachments', 'AttachmentController',
    [
        'only' => [
            'destroy',
        ],
        'names' => [
            'destroy' => 'maintenance.attachments.destroy',
        ],
    ]
);

Route::delete('attachments/uploaded', [
    'as' => 'maintenance.attachments.uploaded.destroy',
]);
