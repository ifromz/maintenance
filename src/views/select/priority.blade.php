{{ Form::select(
        'priority', 
        trans('maintenance::priorities'), 
        (isset($priority) ? $priority : '0'), 
        array('class'=>'form-control select2', 'placeholder'=>'ex. Low / Lowest')
    ) 
}}