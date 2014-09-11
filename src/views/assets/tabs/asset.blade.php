<style>
    .slider-size {
    height: 200px; /* This is your slider height */
    width: 300px; /* This is your slider height */
    }
    .carousel {
        width:100%;
        margin:0 auto; /* center your carousel if other than 100% */ 
    }
</style>

    <div class="col-md-3">
        <div class="slider-size">
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
                            <div style="background:url({{ Storage::url($image->file_path.$image->file_name) }}) center center; 
                  background-size:cover;" class="slider-size">
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="item active">
                        <a href="{{ route('maintenance.assets.images.create', array($asset->id)) }}">
                            <img src="http://placehold.it/300x200&text=Click+To+Add+Pictures" alt="Placeholder">
                        </a>
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
    </div>
    
    <div class="col-md-9">
        
       <dl class="dl-horizontal">
        
            <dt>Name:</dt>
            <dd>{{ $asset->name }}</dd>
            
            <p></p>
            
            <dt>Added:</dt>
            <dd>{{ $asset->created_at }}</dd>
            
            <p></p>
            
            <dt>Added By:</dt>
            <dd>{{ $asset->user->full_name }}</dd>
            
            <p></p>
            
            <dt>Aquired At:</dt>
            <dd>{{ ($asset->aquired_at ? $asset->aquired_at : '<em>None</em>') }}</dd>
            
            <p></p>
            
            <dt>Location:</dt>
            <dd>{{ renderNode($asset->location) }}</dd>
            
            <p></p>
            
            <dt>Category:</dt>
            <dd>{{ renderNode($asset->category) }}</dd>
       </dl>
    </div>
    
        <div class="col-md-12"><hr></div>
    
    <div class="clearfix"></div> 
    
    
    <div class="col-md-2">
        <legend>QR Code</legend>
        
        <center>
            @include('maintenance::partials.qr', array(
                'content' => route('maintenance.assets.show', array($asset->id))
            ))
        </center>
    </div>
    
    
    
<div class="clearfix"></div>