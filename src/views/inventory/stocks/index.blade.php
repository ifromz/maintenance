@extends('maintenance::layouts.pages.main.panel')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('panel.head.content')

    <div class="btn-toolbar">
        <a href="{{ route('maintenance.inventory.create') }}" class="btn btn-primary" data-toggle="tooltip"
           title="Add new Item to inventory">
            <i class="fa fa-plus"></i>
            Add Stock
        </a>
    </div>

@stop

@section('panel.body.content')

    @if($item->stocks->count() > 0)
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Location</th>
                <th>Quantity</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($item->stocks as $stock)
                <tr>
                    <td>{{ $stock->location->trail }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ $stock->created_at }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('maintenance.inventory.stocks.show', array($stock->id)) }}">
                                        <i class="fa fa-search"></i> View Movements
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('maintenance.inventory.stocks.edit', array($stock->id)) }}">
                                        <i class="fa fa-edit"></i> Update Stock
                                    </a>
                                </li>
                                <li>
                                    <a
                                            href="{{ route('maintenance.inventory.stocks.destroy', array($stock->id)) }}"
                                            data-method="delete"
                                            data-message="Are you sure you want to delete this stock for this item?">
                                        <i class="fa fa-trash-o"></i> Delete Stock
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
        <h5>There are no stocks to display for this item.</h5>
    @endif

@stop