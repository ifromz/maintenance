<?php namespace Stevebauman\Maintence\Requests;

use Config;
use Stevebauman\Maintence\Requests\AbstractUploadRequest;

class AssetImageUploadRequest extends AbstractUploadRequest {
	
	public function __construct(){
		$this->uploadPath = Config::get('maintenance::site.paths.assets.images');
	}
	
}