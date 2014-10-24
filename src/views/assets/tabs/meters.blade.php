<legend>Meters & Readings</legend>

@include('maintenance::assets.modals.meters.create', array('asset'=>$asset))

<a class="btn btn-app"
   data-toggle="modal" data-target="#create-reading-modal"
   >
    <i class="fa fa-dashboard"></i> Add a Meter
</a>

<hr>

<div id="asset-meters-table">
    @if($asset->meters->count() > 0)

    <table class="table table-striped">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Last Reading</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($asset->meters as $meter)
                <tr>
                    <td>{{ $meter->name }}</td>
                    <td>{{ $meter->last_reading }} {{ $meter->metric->name }}</td>
                    <td>{{ $meter->user->full_name }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a data-toggle="modal" data-target="#update-reading-modal-{{ $meter->id }}">
                                        <i class="fa fa-refresh"></i>
                                        Update Reading
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ route('maintenance.assets.meters.show', array($meter->id)) }}">
                                        <i class="fa fa-search"></i> View Meter Readings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('maintenance.assets.meters.edit', array($meter->id)) }}">
                                        <i class="fa fa-edit"></i> Edit Meter
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('maintenance.assets.meters.destroy', array($asset->id, $meter->id)) }}" 
                                       data-method="delete" 
                                       data-message="Are you sure you want to delete this meter? All readings will be lost.">
                                        <i class="fa fa-trash-o"></i> Delete Meter
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        @include('maintenance::assets.modals.meters.update', array(
                            'asset'=>$asset,
                            'meter'=>$meter
                        ))
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    @else
    
        <h5>There are no meters to display for this asset.</h5>
        
    @endif
</div>