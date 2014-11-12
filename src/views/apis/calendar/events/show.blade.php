<dt>Name:</dt>
<dd>{{ $event->name }}</dd>

<p></p>

<dt>Description:</dt>
<dd>{{ $event->description }}</dd>

<p></p>


<legend>Assets Included</legend>

<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>
                Name
            </th>
            <th>
                View
            </th>
        </tr>
    </thead>
    <tbody>
        @if($event->isRecurrence())
            
            @foreach($event->getParent()->assets as $asset)
            <tr>
                <td>
                    {{ $asset->name }}
                </td>
                <td>
                    <a class="btn btn-primary" href="{{ route('maintenance.assets.show', array($asset->id)) }}">
                        <i class="fa fa-search"></i> View Asset
                    </a>
                </td>
            </tr>
            @endforeach
        
        @else
        
            @foreach($event->assets as $asset)
            <tr>
                <td>
                    {{ $asset->name }}
                </td>
                <td>
                    <a class="btn btn-primary" href="{{ route('maintenance.assets.show', array($asset->id)) }}">
                        <i class="fa fa-search"></i> View Asset
                    </a>
                </td>
            </tr>
            @endforeach
        
        @endif
        
        
    </tbody>
</table>