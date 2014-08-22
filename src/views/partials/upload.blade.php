<tr>
	<td>{{ HTML::link(Storage::url($file_path), $file->getClientOriginalName(), array('target'=>'_blank')) }}</td>
	<td>
    	{{ HTML::link('', 'Delete', array('class'=>'btn btn-danger btn-xs delete-file-uploaded', 'data-file-path'=>$file_path, 'data-file-folder'=>$file_folder)) }}
        {{ Form::hidden('files[]', sprintf('%s|%s', $file->getClientOriginalName(), $file_folder)) }}
    </td>
</tr>