<?php

return array(
        
        /*
         * The integer which tells the system when the work order is complete or not 
         */
        'complete' => 1, //**MUST BE AN INTEGER**
        
        /*
         * Options to list for dropdown box
         */
        'options' => array(
            '0' => trans('maintenance::statuses.0'),
            '1' => trans('maintenance::statuses.1'),
            '2' => trans('maintenance::statuses.2'),
            '3' => trans('maintenance::statuses.3'),
            '4' => trans('maintenance::statuses.4'),
            '5' => trans('maintenance::statuses.5'),
        ),
        
        /*
         * Colors to display in reference to the id's
         */
	'colors' => array(
                '0' => 'default',
		'1' => 'success',
		'2' => 'danger',
		'3' => 'info',
		'4' => 'warning',
                '5' => 'warning',
	),
	
);