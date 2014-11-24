@if($workOrder->attachments->count() > 0)

<table class="table">
    <thead>
        <tr>
            <th>Attachment</th>
            <th>Name</th>
            <th class="hidden-xs">File Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($workOrder->attachments as $attachment)
        <tr>
            <td width="200">
                <a href="{{ Storage::url($attachment->file_path.$attachment->file_name) }}">{{ $attachment->file_name }}</a>
            </td>
            <td>{{ $attachment->name }}</td>
            <td class="hidden-xs">{{ $attachment->file_name }}</td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('maintenance.work-orders.attachments.show', array($workOrder->id, $attachment->id)) }}">
                                <i class="fa fa-search"></i> View Attachment
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('maintenance.work-orders.attachments.destroy', array($workOrder->id, $attachment->id)) }}" data-method="delete" data-message="Are you sure you want to delete this image?">
                                <i class="fa fa-trash-o"></i> Delete Attachment
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

<h5>There are currently no attachments to list.</h5>

@endif