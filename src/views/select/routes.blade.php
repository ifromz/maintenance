{{
    Form::select(
        'routes[]',
        $allRoutes,
        (isset($routes) ? array_keys($routes) : null),
        array(
            'class'=>'form-control select2',
            'placeholder' => 'Enter Routes',
            'multiple'=>true
        )
    )
}}
