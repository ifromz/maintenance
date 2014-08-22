<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class AssetValidator extends AbstractValidator {
	
	protected $rules = array(
		'name' => 'required|min:3',
		'condition' => 'required|integer',
		'asset_category' => 'required',
		'asset_category_id' => '',
	);
	
}