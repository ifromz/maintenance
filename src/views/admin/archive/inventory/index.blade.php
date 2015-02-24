@extends('maintenance::layouts.admin')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('content')

    @include('maintenance::inventory.modals.search', array(
        'url' => route(currentRouteName(), Input::only('field', 'sort'))
    ))

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="btn-toolbar">
                <a href="#" class="btn btn-primary" data-target="#search-modal" data-toggle="modal"
                   title="Filter results">
                    <i class="fa fa-search"></i>
                    Search
                </a>
            </div>
        </div>

        <div id="resource-paginate" class="panel-body">
            @if($items->count() > 0)
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ link_to_sort('maintenance.inventory.index', 'ID', array('field'=>'id', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort('maintenance.inventory.index', 'Name', array('field'=>'name', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort('maintenance.inventory.index', 'Category', array('field'=>'category_id', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort('maintenance.inventory.index', 'Current Stock', array('field'=>'stocks.quantity', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort('maintenance.inventory.index', 'Description', array('field'=>'description', 'sort'=>'asc')) }}</th>
                        <th>{{ link_to_sort('maintenance.inventory.index', 'Added', array('field'=>'created_at', 'sort'=>'asc')) }}</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category->trail }}</td>
                            <td>{{ $item->current_stock }}</td>
                            <td>{{ $item->description_short }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                        Action
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('maintenance.admin.archive.inventory.restore', array($item->id)) }}"
                                               data-method="POST"
                                               data-message="Are you sure you want to restore this inventory item?">
                                                <i class="fa fa-refresh"></i> Restore
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{{ route('maintenance.admin.archive.inventory.show', array($item->id)) }}">
                                                <i class="fa fa-search"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a
                                                    href="{{ route('maintenance.admin.archive.inventory.destroy', array($item->id)) }}"
                                                    data-method="delete"
                                                    data-message="Are you sure you want to delete this item?">
                                                <i class="fa fa-trash-o"></i> Delete (Permanent)
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <div class="btn-toolbar text-center">
                        {{ $items->appends(Input::except('page'))->links() }}
                    </div>
                    </tbody>
                </table>
            @else
                <h5>There are no inventory items to list.</h5>
            @endif
        </div>
    </div>

@stop