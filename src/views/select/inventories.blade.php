{{ Form::select(
            'inventories[]', 
            $allInventories, 
            (isset($inventories) ? $inventories : NULL), 
            array('class'=>'form-control select2', 'placeholder'=>'Search inventory...', 'multiple'=>true)) 
}}