<div class="col-md-3">
    
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @if($asset->images->count() > 1)
                @foreach($asset->images as $image)
                    @if($asset->images->first()->id == $image->id)
                        <li data-target="#carousel-example-generic" data-slide-to="" class="active"></li>
                    @else
                        <li data-target="#carousel-example-generic" data-slide-to="" class=""></li>
                    @endif
                @endforeach
            @endif
        </ol>
        <div class="carousel-inner">
        @if($asset->images->count() > 0)
            @foreach($asset->images as $image)
            
            @if($asset->images->first()->id == $image->id)
                <div class="item active">
                    
            @else
                <div class="item">
            @endif
                    <a href="{{ route('maintenance.assets.images.show', array($asset->id, $image->id)) }}"><img class="img-responsive" src="{{ Storage::url($image->file_path.$image->file_name) }}"></a>
                </div>
            @endforeach
        @else
            <div class="item active">
                <img src="http://placehold.it/700x500&text=No+Images+Found" alt="Placeholder">
            </div>
        @endif
        </div>
        @if($asset->images->count() > 1)
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        @endif
    </div>
</div>      