<?php 

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\AssetService;

class AssetSelectComposer {
    
    public function __construct(AssetService $asset){
        $this->asset = $asset;
    }
    
    public function compose($view){
        $allAssets = $this->asset->get()->lists('name', 'id');
        
        return $view->with('allAssets', $allAssets);
    }
    
}
