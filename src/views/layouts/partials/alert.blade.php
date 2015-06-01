<div class="row">

    @if ($errors->any())
        <div class="col-md-12">
            <div class="notifications alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
                @if ($message = $errors->first(0, ':message'))
                    {{ $message }}
                @else
                    There were errors with the form you've sent.
                @endif
            </div>
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="col-md-12">
            <div class="notifications alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
                {{ $message }}
            </div>
        </div>
    @endif

    <div class="col-md-12">
        <div id="alert-container">
            @if(Session::get('message'))
                <div class="col-md-12">
                    <div class="alert alert-{{ Session::get('messageType') }} alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('message') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
