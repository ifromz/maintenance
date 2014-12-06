<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\BaseValidator;

class AssetValidator extends BaseValidator {
	
	protected $rules = array(
		'name' => 'required|min:3|max:250',
		'condition' => 'required|integer',
		'asset_category' => 'required',
		'asset_category_id' => 'integer',
                'location' => 'required',
                'location_id' => 'integer'
	);
	
}