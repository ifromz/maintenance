{{
    Form::select(
        'groups[]',
        $allGroups,
        (isset($groups) ? array_keys($groups) : NULL),
        array(
            'class'=>'form-control select2',
            'placeholder' => 'Enter Groups',
            'multiple'=>true
        )
    )
}}