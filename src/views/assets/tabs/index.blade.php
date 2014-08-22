<div class="col-md-6">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
        	@if($asset->images->count() > 0)
            <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
            <li data-target="#carousel-example-generic" data-slide-to="1" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
            @endif
        </ol>
        <div class="carousel-inner">
        	@if($asset->images->count() > 0)
            <div class="item">
                <img src="http://placehold.it/900x500/39CCCC/ffffff&amp;text=I+Love+Bootstrap" alt="First slide">
                <div class="carousel-caption">
                    First Slide
                </div>
            </div>
            @else
                <div class="item active">
                    <img src="http://placehold.it/700x500&text=No+Images+Found" alt="Third slide">
                </div>
            @endif
        </div>
        @if($asset->images->count() > 0)
        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
        @endif
    </div>
</div>      