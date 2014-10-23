{{ Form::select(
        'control', 
        Config::get('maintenance::controls'), 
        (isset($control) ? $control : '0'), 
        array('class'=>'form-control select2')
    ) 
}}