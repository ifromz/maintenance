@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop


@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.assets.index') }}">
            <i class="fa fa-truck"></i>
            Assets
        </a>
    </li>
    <li>
        <a href="{{ route('maintenance.assets.show', array($asset->id)) }}">
            {{ $asset->name }}
        </a>
    </li>
    <li>
        <i class="fa fa-dashboard"></i>
        Meters
    </li>
    <li class="active">
        {{ $meter->name }}
    </li>
@stop

@section('content')

    <div class="panel panel-default">

        @include('maintenance::assets.modals.meters.update', array(
            'asset'=>$asset,
            'meter'=>$meter
        ))

        <div class="panel-heading">
            <div class="btn-toolbar">
                <a class="btn btn-primary" data-toggle="modal" data-target="#update-reading-modal-{{ $meter->id }}">
                    <i class="fa fa-plus-circle"></i>
                    New Reading
                </a>
            </div>
        </div>

        <div id="asset-meters-table" class="panel-body">

            <div id="resource-paginate">

                @include('maintenance::assets.meters.menu', array(
                    'asset' => $asset,
                    'meter' => $meter,
                ))

                <hr>

                @if($readings->count() > 0)

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>User Responsible</th>
                            <th>Reading</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($readings as $reading)
                            <tr>
                                <td>{{ $reading->user->full_name }}</td>
                                <td>{{ $reading->reading }} {{ $meter->metric->symbol }}</td>
                                <td>{{ $reading->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                            Action
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('maintenance.assets.meters.readings.destroy', array($asset->id, $meter->id, $reading->id)) }}"
                                                   data-method="delete"
                                                   data-message="Are you sure you want to delete this reading?">
                                                    <i class="fa fa-trash-o"></i> Delete Reading
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

                    <h5>There are no readings to display for this meter.</h5>

                @endif

                <div class="btn-toolbar text-center">
                    {{ $readings->links() }}
                </div>

            </div>

        </div>

    </div>

@stop