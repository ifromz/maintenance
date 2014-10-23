{{ Form::select(
        'priority', 
        $priorities, 
        (isset($priority) ? $priority : NULL), 
        array('class'=>'form-control select2', 'placeholder'=>'ex. Low / Lowest')
    ) 
}}