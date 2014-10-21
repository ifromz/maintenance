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
                    'destroy' => 'maintenace.attachments.destroy',
            ),
        )
);