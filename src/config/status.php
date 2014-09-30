<?php

return array(
        
        /*
         * The integer which tells the system when the work order is complete or not 
         */
        'complete' => 0, //**MUST BE AN INTEGER**
        
        /*
         * Options to list for dropdown box
         */
        'options' => array(
            NULL => trans('maintenance::statuses.none'),
            '0' => trans('maintenance::statuses.0'),
            '1' => trans('maintenance::statuses.1'),
            '2' => trans('maintenance::statuses.2'),
            '3' => trans('maintenance::statuses.3'),
            '4' => trans('maintenance::statuses.4'),
        ),
        
        /*
         * Colors to display in reference to the id's
         */
	'colors' => array(
		'0' => 'success',
		'1' => 'danger',
		'2' => 'info',
		'3' => 'warning',
                '4' => 'warning',
	),
	
);