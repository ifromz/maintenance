<?php namespace Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Attachment extends Eloquent {
	
	protected $table = 'attachments';
	
        protected $fillable = array('name', 'file_name', 'file_path');
}