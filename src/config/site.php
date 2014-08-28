<?php

return array(
	'prefix' => '/', // Prefix of the application (ex. http://www.example.com/maintenance/)
	
	'title' => array(
            'backend' => 'Maintenance', // Title of the backend Application
            'public' => 'Maintenance', // Title of the frontend Application
        ),
	
    
    
	// Paths for file storage. All paths have to end with trailing slash
	'paths' => array(
		'base' => 'files/', // Base default storage location
		
		'temp' => 'temp/', // Temporary file location storage for ajax uploads, these will be cleared periodically 
		
		'assets' => array(
			'images' => 'assets/images/',
			'manuals' => '',
		),
	),
	
);