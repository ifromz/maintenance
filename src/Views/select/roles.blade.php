{!!
    Form::select(
        'groups[]',
        $allRoles,
        (isset($roles) ? array_keys($roles) : null),
        [
            'class'=>'form-control select2',
            'placeholder' => 'Enter Groups',
            'multiple'=>true
        ]
    )
!!}
