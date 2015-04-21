<div id="asset-meters-table">
    @if($asset->meters->count() > 0)
        {{
            $asset->meters->columns(array(
                'name' => 'Name',
                'last_reading' => 'Last Reading',
                'last_comment' => 'Comment',
                'created_by' => 'Created By',
                'action' => 'Action',
            ))
            ->means('created_by', 'user.full_name')
            ->modify('last_reading', function($reading) {
                return $reading->last_reading. ' '.$reading->metric->symbol;
            })
            ->modify('action', function($meter) use ($asset) {
                return $meter->viewer()->btnActionsForAsset($asset);
            })
            ->render()
        }}
    @else
        <h5>There are no meters to display for this asset.</h5>
    @endif
</div>