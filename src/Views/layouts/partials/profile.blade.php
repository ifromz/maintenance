<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-user"></i>
        <span>Profile <i class="caret"></i></span>
    </a>
    <ul class="dropdown-menu">

        <!-- Menu Body -->
        <li class="user-body">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $currentUser->first_name }} {{ $currentUser->last_name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $currentUser->email }}</td>
                    </tr>
                    <tr>
                        <th>Last Login</th>
                        <td>{{ $currentUser->last_login }}</td>
                    </tr>
                </tbody>
            </table>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            @if($currentUser->hasAccess('maintenance.admin.dashboard.index'))
                <div class="pull-left">
                    <a href="{{ route('maintenance.admin.dashboard.index') }}" class="btn btn-default btn-flat">Admin Dashboard</a>
                </div>
            @endif
            <div class="pull-right">
                <a href="{{ route('maintenance.logout') }}" class="btn btn-default btn-flat">Sign out</a>
            </div>
        </li>

    </ul>
</li>
