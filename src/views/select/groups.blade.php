{{
    Form::select(
        'groups[]',
        $allGroups,
        (isset($groups) ? array_keys($groups) : null),
        array(
            'class'=>'form-control select2',
            'placeholder' => 'Enter Groups',
            'multiple'=>true
        )
    )
}}
