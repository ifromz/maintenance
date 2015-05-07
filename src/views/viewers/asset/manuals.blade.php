@if($asset->manuals->count() > 0)
    {{
        $asset->manuals
            ->columns([
                'name' => 'Name',
                'file_name' => 'File Name',
                'action' => 'Action'
            ])
            ->modify('action', function($manual) use ($asset) {
                return $manual->viewer()->btnActionsForAssetManual($asset);
            })
            ->render()
    }}
@else
    <h5>There are no manuals attached to this asset.</h5>
@endif
