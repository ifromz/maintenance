 <div class="btn-group">
     <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
        Action
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        @if(is_array($actions))
            @foreach($actions as $action)
                <li>
                    <a href="{{ $action['link'] }}">
                        <i class="{{ $action['icon'] }}}"></i> {{ $action['name'] }}
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
</div>