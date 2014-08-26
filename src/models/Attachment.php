<?php namespace Stevebauman\Maintenance\Models;

class Attachment extends \Eloquent {
	
	protected $table = 'attachments';
	
        protected $fillable = array('name', 'file_name', 'file_path');
}