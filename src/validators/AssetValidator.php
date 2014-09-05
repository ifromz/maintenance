<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class AssetValidator extends AbstractValidator {
	
	protected $rules = array(
		'name' => 'required|min:3|alpha_dash',
		'condition' => 'required|integer',
		'asset_category' => 'required|alpha_dash',
		'asset_category_id' => 'integer',
	);
	
}