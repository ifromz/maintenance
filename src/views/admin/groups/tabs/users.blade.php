@if($group->users->count() > 0)

<table class="table table-striped">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Action</th>
        </tr>
    </thead>
    
    <tbody>
        @foreach($group->users as $user)
        <tr>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>
               <div class="btn-group">
                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('maintenance.admin.users.show', array($user->id)) }}">
                                <i class="fa fa-search"></i> View User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('maintenance.admin.users.edit', array($user->id)) }}">
                                <i class="fa fa-edit"></i> Edit User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('maintenance.admin.users.destroy', array($user->id)) }}" data-method="delete" data-message="Are you sure you want to delete this work order?">
                                <i class="fa fa-trash-o"></i> Delete User
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
<h5>There are no users to display.</h5>
@endif