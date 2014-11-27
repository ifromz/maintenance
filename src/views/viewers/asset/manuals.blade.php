@if($asset->manuals->count() > 0)

{{ $asset->manuals->columns(array(
                        'name' => 'Name',
                        'file_name' => 'File Name',
                        'action' => 'Action'
                    ))
                    ->modify('action', function($manual) use ($asset) {
                        return $manual->viewer()->btnActionsForAssetManual($asset);
                    })
                    ->render() }}
                    
@else

<h5>There are no manuals to list</h5>

@endif