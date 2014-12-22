{{ Form::select(
            'work_orders[]', 
            $allWorkOrders, 
            (isset($workOrders) ? $workOrders : NULL), 
            array('class'=>'form-control select2', 'placeholder'=>'Search for work orders...', 'multiple'=>true)) 
}}