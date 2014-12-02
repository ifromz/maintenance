<?php namespace Stevebauman\Maintenance\Apis;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Apis\BaseApiController;

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
        
        public function getMakes(){
		$records = $this->asset->getMakes(Input::get('query'));
		
		return Response::json($records->lists('make'));
	}
	
	public function getModels(){
		$records = $this->asset->getModels(Input::get('query'));
		
		return Response::json($records->lists('model'));
	}
	
	public function getSerials(){
		$records = $this->asset->getSerials(Input::get('query'));
		
		return Response::json($records->lists('serial'));
	}
}