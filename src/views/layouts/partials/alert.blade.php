<div class="row">

    <div class="col-md-12">
        <div id="alert-container">
            @if(Session::has('errors'))
                <div class="alert alert-danger">
                    <p>The following errors have occured:</p>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if(Session::get('message'))
        <div class="col-md-12">
            <div class="alert alert-{{ Session::get('messageType') }} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ Session::get('message') }}
            </div>
        </div>
    @endif

</div>