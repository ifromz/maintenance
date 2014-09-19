<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Inventory;
use Stevebauman\Maintenance\Services\AbstractModelService;

class InventoryService extends AbstractModelService {
    
    public function __construct(Inventory $inventory, SentryService $sentry){
        $this->model = $inventory;
        $this->sentry = $sentry;
    }
    
    public function getByPageWithFilter($data = array()){
		return $this->model
			->with(array(
				'category',
				'user',
                                'stocks',
			))
                        ->name((array_key_exists('name', $data) ? $data['name'] : NULL))
                        ->description((array_key_exists('description', $data) ? $data['description'] : NULL))
                        ->location((array_key_exists('location_id', $data) ? $data['location_id'] : NULL))
                        ->stock(
                                (array_key_exists('operator', $data) ? $data['operator'] : NULL),
                                (array_key_exists('quantity', $data) ? $data['quantity'] : NULL)
                        )
                        ->orderBy('created_at', 'DESC')
			->paginate(25);
	}
    
    public function create($data){
        
        $insert = array(
            'category_id' => $data['category_id'],
            'user_id' => $this->sentry->getCurrentUserId(),
            'name' => $this->clean($data['name']),
            'description' => $this->clean($data['description']),
        );
        
        if($record = $this->model->create($insert)){
            return $record;
        } else{
            return false;
        }
        
    }
    
    public function update($id, $data){
        if($record = $this->find($id)){
            
            $insert = array(
                'category_id' => $data['category_id'],
                'name' => $this->clean($data['name']),
                'description' => $this->clean($data['description']),
            );
            
            if($record->update($insert)){
                return $record;
            }
            
        } return false;
    }
}