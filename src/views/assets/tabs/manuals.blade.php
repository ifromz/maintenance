@if($asset->manuals->count() > 0)

<table class="table table-condensed table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($asset->manuals as $manual)
        <tr>
            <td>
                {{ $manual->name }}
            </td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ $manual->manual_link }}">
                                <i class="fa fa-search"></i> View Manual
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('maintenance.assets.manuals.destroy', array($asset->id, $manual->id)) }}" data-method="delete" data-message="Are you sure you want to delete this asset?">
                                <i class="fa fa-trash-o"></i> Delete Manual
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
    
</table>

@else

@endif