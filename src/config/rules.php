<?php

return array(
    
    'meters' => array(
        
        /*
         * Set this to true if you want to prevent a new reading from being created
         * if they equal the same number. This can be handy if you only want new
         * records when the reading actually changes.
         */
        'prevent_duplicate_entries' => true,
        
    ),
    
    'work-orders' => array(
        
        /*
         * Set enabled to true if you want to prevent a lot of work order updates 
         * (technician or customer) from being created. Set the minutes apart
         * they must be submitted by.
         * 
         * Ex. If a technician posts an update, he cannot create another update for
         * 5 minutes.
         * 
         */
        'prevent_spam_updates' => array(
            'enabled' => 'true',
            'minutes_apart' => '5'
        )
        
    ),
    
    'inventory' => array(
        
        /*
         * Set this to true if you want to prevent inventory movements from being
         * created if the quantity inputted by the user is the same as the
         * current quantity.
         */
        'prevent_duplicate_movements' => true,
        
    )
    
);