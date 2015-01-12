@if($item->notes->count() > 0)

    {{

     $item->notes->columns(array(
        'user' => 'Created By',
        'content' => 'Note',
        'action' => 'Action'
     ))
     ->means('user', 'user.fullname')
     ->render()

     }}

@else

    <h5>There are no notes to display.</h5>

@endif