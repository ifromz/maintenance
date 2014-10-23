<?php

namespace Stevebauman\Maintenance\Models;

use Illuminate\Support\Facades\Config;
use Stevebauman\Maintenance\Models\BaseModel;

class Status extends BaseModel {
    
    protected $table = 'statuses';
    
    protected $fillable = array(
        'user_id',
        'name',
        'color',
        'control'
    );
    
    public function user(){
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
    }
    
    public function getControlAttribute($control)
    {
        return Config::get(sprintf('maintenance::controls.%s', $control));
    }
    
    public function getLabelAttribute()
    {
        return sprintf(
                '<span class="label label-%s">%s</span>', 
                    $this->attributes['color'], 
                    $this->getControlAttribute($this->attributes['control'])
            );
    }
    
    /**
     * Compatibility with Revisionable
     * 
     * @return string
     */
    public function identifiableName()
    {
        return $this->name;
    }
    
}