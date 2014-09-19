<?php namespace Stevebauman\Maintenance\Models;

use Dmyers\Storage\Storage;
use Stevebauman\Maintenance\Models\BaseModel;

class Attachment extends BaseModel {
	
	protected $table = 'attachments';
	
        protected $fillable = array('name', 'file_name', 'file_path');
        
        public function getManualLinkAttribute(){
            return Storage::url($this->attributes['file_path'].$this->attributes['file_name']);
        }
}