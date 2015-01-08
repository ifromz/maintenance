@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li class="active">
        <a href="{{ action(currentControllerAction('index')) }}">
            {{ str_plural($resource) }}
        </a>
    </li>
@stop

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading">
            <div class="btn-toolbar">
                <a href="{{ action(currentControllerAction('create')) }}" class="btn btn-primary" data-toggle="tooltip"
                   title="" data-original-title="Create a new {{ $resource }}">
                    <i class="fa fa-plus"></i>
                    New {{ $resource }}
                </a>

                <a id="edit-category"
                   data-toggle="tooltip" title=""
                   data-original-title="Edit Selected {{ $resource }}"
                   class="btn btn-warning"
                   style="display:none;" href="">
                    <i class="fa fa-pencil"></i>
                    Edit {{ $resource }}
                </a>

                <a id="create-sub-category"
                   data-toggle="tooltip" title=""
                   data-original-title="Create a new Sub {{ $resource }}"
                   class="btn btn-success"
                   style="display:none;" href="">
                    <i class="fa fa-plus"></i>
                    New Sub-{{ $resource }}
                </a>

                <div class="pull-right">
                    <a
                            href="{{ action(currentControllerAction('destroy')) }}"
                            data-method="delete"
                            data-message="
                        Are you sure you want to delete this {{ $resource }}? This can have a large cascade effect. 
                        Anything attached to this {{ $resource }} will be deleted, as well as {{ str_plural($resource) }} below the selected {{ $resource }}.
                        You should move or rename the {{ $resource }} instead of deleting it if possible.
                    "
                            id="delete-sub-category"
                            data-toggle="tooltip"
                            title=""
                            data-original-title="Delete selected {{ $resource }}"
                            class="btn btn-danger"
                            style="display:none;"
                            >
                        <i class="fa fa-trash-o"></i>
                        Delete {{ $resource }}
                    </a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            <div class="category-tree"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="tree"></div>
                </div>

                <script>
                    $(document).ready(function (e) {
                        var json_category_tree = null;

                        $.get("{{ action(currentControllerAction('getJson')) }}", function (data) {
                            json_category_tree = data;
                        }).done(function () {
                            if (json_category_tree != null) {
                                $('.tree').on('changed.jstree', function (e, data) {

                                    $('#edit-category').css('display', 'inline-block');
                                    $('#create-sub-category').css('display', 'inline-block');
                                    $('#delete-sub-category').css('display', 'inline-block');

                                    for (i = 0, j = data.selected.length; i < j; i++) {
                                        $('#edit-category').attr('href', window.location.href.toString() + "/" + data.instance.get_node(data.selected[i]).id + "/edit");
                                        $('#create-sub-category').attr('href', window.location.href.toString() + "/create/" + data.instance.get_node(data.selected[i]).id);
                                        $('#delete-sub-category').attr('href', window.location.href.toString() + "/" + data.instance.get_node(data.selected[i]).id);
                                    }
                                }).jstree({
                                    "plugins": ["core", "json_data", "themes", "ui", "dnd", "crrm"],
                                    'core': {
                                        'data': json_category_tree,
                                        'check_callback': true
                                    }
                                }).bind("loaded.jstree", function (event, data) {
                                    $(this).jstree("open_all");
                                }).bind("move_node.jstree", function (e, data) {
                                    $.post(
                                            window.location.href.toString() + "/move/" + data.node.id,
                                            {
                                                "parent_id": data.node.parent
                                            }
                                    );
                                });
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
@stop



