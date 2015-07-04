@extends('maintenance::layouts.main')

@section('title', 'Viewing Image')

@section('content')
    <div class="col-md-12 col-md-offset-4">
        <img class="img-responsive" src="{{ asset($image->file_path) }}">

        <div class="btn-group" role="group">
            <a class="btn btn-primary btn-lg" href="{{ route('maintenance.assets.images.download', [$asset->id, $image->id]) }}"><i class="fa fa-download"></i> Download</a>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cog"></i>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a
                                data-message="Are you sure you want to delete this attachment?"
                                data-method="DELETE"
                                data-token="{{ csrf_token() }}"
                                href="{{ route('maintenance.assets.images.destroy', [$asset->id, $image->id]) }}"
                                >
                            <i class="fa fa-trash"></i> Delete
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@stop
