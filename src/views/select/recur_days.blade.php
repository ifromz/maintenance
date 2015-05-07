{{ Form::select('recur_days[]', trans('maintenance::recur.days'), (isset($days) ? $days : null), ['class'=>'form-control select2', 'placeholder'=>'Select Days', 'multiple'=>true]) }}
