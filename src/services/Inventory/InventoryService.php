<?php 

namespace Stevebauman\Maintenance\Services;

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
    
    public function getByPageWithFilter(){
            return $this->model
                    ->with(array(
                            'category',
                            'user',
                            'stocks',
                    ))
                    ->name($this->getInput('name'))
                    ->description($this->getInput('description'))
                    ->category($this->getInput('category_id'))
                    ->location($this->getInput('location_id'))
                    ->stock(
                            $this->getInput('operator'),
                            $this->getInput('quantity')
                    )
                    ->orderBy('created_at', 'DESC')
                    ->paginate(25);
    }
    
    public function create(){
        
        $insert = array(
            'category_id' => $this->getInput('category_id'),
            'user_id' => $this->sentry->getCurrentUserId(),
            'name' => $this->getInput('name', NULL, true),
            'description' => $this->getInput('description', NULL, true),
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
                'category_id' => $this->getInput('category_id'),
                'name' => $this->getInput('name', $record->name, true),
                'description' => $this->getInput('description', $record->description, true),
            );
            
            if($record->update($insert)){
                return $record;
            }
            
        } return false;
    }
}