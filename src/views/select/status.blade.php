{{ Form::select(
            'status',
            $statuses,
            (isset($status) ? $status : NULL),
            array('class'=>'form-control select2', 'placeholder'=>'ex. Repaired / Awaiting for Parts')
        )
}}
