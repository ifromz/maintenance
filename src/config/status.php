<?php

return array(
        
        /*
         * The integer which tells the system when the work order is complete or not
         */
        'complete' => '0',
        
        /*
         * Options to list for dropdown box
         */
        'options' => array(
            '0' => trans('maintenance::statuses.0'),
            '1' => trans('maintenance::statuses.1'),
            '2' => trans('maintenance::statuses.2'),
            '3' => trans('maintenance::statuses.3'),
        ),
        
        /*
         * Colors to display in reference to the id's
         */
	'colors' => array(
		'0' => 'success',
		'1' => 'danger',
		'2' => 'info',
		'3' => 'warning',
	),
	
);