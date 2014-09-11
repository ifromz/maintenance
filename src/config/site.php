<?php

return array(
        /*
         * Prefix of the application (ex. http://www.example.com/maintenance/)
         */
	'prefix' => '/',
	
        /*
         * Title of the backend Application
         */
	'title' => array(
            'backend' => 'Maintenance',
        ),
	
        /*
         * LDAP Settings
         */
        'ldap' => array(
            /*
             * Enables use of LDAP for logging in. You must publish the config 
             * file of Stevebauman\Corp and fill in your settings to use LDAP.
             */
           'enabled' => true,
            
            'user_sync' => array(
                /*
                 * Enables the maintenance seeder to add LDAP users to the web database so they are visble
                 * for assigning work orders and managing permissions.
                 */
                'enabled' => true,
                
                /*
                 * Filters for the user sync. Set enabled to false to allow all users detected on LDAP to be added
                 */
                'filters' => array(
                    
                    'enabled' => true,
                    
                    /*
                     * User groups to allow **MUST BE ARRAY IF ENABLED - FALSE OTHERWISE**
                     */
                    'groups' => array('Maintenance', 'User Accounts'),
                    
                    /*
                     * User types to allow **MUST BE ARRAY IF ENABLED - FALSE OTHERWISE**
                     */
                    'types' => array('Managers', 'Students'),
                ),
                
            ),
        ),
        
    
	// Paths for file storage. All paths have to end with trailing slash
	'paths' => array(
		'base' => 'files/', // Base default storage location
		
		'temp' => 'temp/', // Temporary file location storage for ajax uploads, these will be cleared periodically 
		
		'assets' => array(
			'images' => 'assets/images/',
			'manuals' => 'assets/manuals/',
		),
	),
	
);