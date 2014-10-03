<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\InventoryNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Inventory;
use Stevebauman\Maintenance\Services\AbstractModelService;

class InventoryService extends AbstractModelService {
    
    public function __construct(Inventory $inventory, SentryService $sentry, InventoryNotFoundException $notFoundException){
        $this->model = $inventory;
        $this->sentry = $sentry;
        $this->notFoundException = $notFoundException;
    }
    
    public function getByPageWithFilter($data = array()){
		return $this->model
			->with(array(
				'category',
				'user',
                                'stocks',
			))
                        ->name($this->input('name'))
                        ->description($this->input('description'))
                        ->category($this->input('category_id'))
                        ->location($this->input('location_id'))
                        ->stock(
                                $this->input('operator'),
                                $this->input('quantity')
                        )
                        ->orderBy('created_at', 'DESC')
			->paginate(25);
	}
    
    public function create(){
        
        $insert = array(
            'category_id' => $this->input('category_id'),
            'user_id' => $this->sentry->getCurrentUserId(),
            'name' => $this->input('name', true),
            'description' => $this->input('description', true),
        );
        
        if($record = $this->model->create($insert)){
            return $record;
        } else{
            return false;
        }
        
    }
    
    public function update($id){
        if($record = $this->find($id)){
            
            $insert = array(
                'category_id' => $this->input('category_id'),
                'name' => $this->input('name', true),
                'description' => $this->input('description', true),
            );
            
            if($record->update($insert)){
                return $record;
            }
            
        } return false;
    }
}