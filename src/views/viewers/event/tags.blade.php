
<dl class="dl-horizontal">

    <dt>Tagged To:</dt>
    <dd>
        @foreach($tags as $tag)

        {{ $tag->eventable->viewer()->btnEventTag }}

        @endforeach
    </dd>
    
</dl>
