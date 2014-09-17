<?php namespace Stevebauman\Maintenance\Http\Apis;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Http\Apis\BaseApiController;

class AssetApi extends BaseApiController {
	
	public function __construct(AssetService $asset){
		$this->asset = $asset;
	}
	
	public function get(){
		$records = $this->asset->get();
		
		return Response::json($records);
	}
        
        public function getByQuery(){
            $term = Input::get('term');
            
            $records = $this->asset->where('name', 'LIKE', '%'.$term.'%')->get();

            return Response::json($records);
	}
}