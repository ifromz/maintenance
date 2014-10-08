<?php namespace Stevebauman\Maintenance\Observers;

use Stevebauman\Maintenance\Observers\AbstractObserver;

class InventoryStockObserver extends AbstractObserver {
    
    public function saved($record){
        
        if($record->quantity < 5){
            
            
            $record->notifications()->create(array(
                'user_id' => 4,
                'message' => sprintf('Stock is getting low for %s in %s', $record->item->name, renderNode($record->location)),
                'link' => route('maintenance.inventory.stocks.show', array($record->item->id, $record->id)),
                'notifiable_id' => $record->id,
                'notifiable_type'=> get_class($record),
            ));
            
        }
    }
    
}
