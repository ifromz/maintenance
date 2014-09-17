{{ Form::select(
            'assets[]', 
            $allAssets, 
            (isset($assets) ? $assets : NULL), 
            array('class'=>'form-control select2', 'placeholder'=>'Search for assets...', 'multiple'=>true)) 
}}