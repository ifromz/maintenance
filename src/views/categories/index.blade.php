@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')

    <div class="btn-toolbar">
        <a href="{{ action(currentControllerAction('create')) }}" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="Create a new Category">
            <i class="fa fa-plus"></i>
            New Category
        </a>
        
        <a id="edit-category" 
            data-toggle="tooltip" title="" 
            data-original-title="Edit Selected Category" 
            class="btn btn-warning" 
            style="display:none;" href="">
                <i class="fa fa-pencil"></i>
                Edit Category
        </a>
        
        <a id="create-sub-category" 
            data-toggle="tooltip" title="" 
            data-original-title="Create a new Sub Category" 
            class="btn btn-success" 
            style="display:none;" href="">
                <i class="fa fa-plus"></i>
                New Sub-Category
        </a>
        
        <div class="pull-right">
             <a 
                href="{{ action(currentControllerAction('destroy')) }}" 
                data-method="delete" data-message="Are you sure you want to delete this category? This can have a large cascade effect."
                id="delete-sub-category"
                data-toggle="tooltip" 
                title="" 
                data-original-title="Delete selected category" 
                class="btn btn-danger" 
                style="display:none;"
            >
                    <i class="fa fa-trash-o"></i>
                    Delete Category
            </a>
        </div>
    </div>
    <p></p>
    <div class="category-tree"></div>
    
    <div class="row">
        <div class="col-md-12">
        	<div class="tree"></div>
        </div>
        
        <script>
		$(document).ready(function(e) {
			var json_category_tree = null; 
			
			$.get("{{ action(currentControllerAction('getJson')) }}", function(data){
				json_category_tree = data;
			}).done(function(){
				if(json_category_tree != null){
					$('.tree').on('changed.jstree', function (e, data) {
						
						$('#edit-category').css('display', 'inline-block');
						$('#create-sub-category').css('display', 'inline-block');
						$('#delete-sub-category').css('display', 'inline-block');
						
						for(i = 0, j = data.selected.length; i < j; i++) {
							$('#edit-category').attr('href', window.location.href.toString()+"/"+data.instance.get_node(data.selected[i]).id+"/edit");
							$('#create-sub-category').attr('href', window.location.href.toString()+"/create/"+data.instance.get_node(data.selected[i]).id);
							$('#delete-sub-category').attr('href', window.location.href.toString()+"/"+data.instance.get_node(data.selected[i]).id);
							
						}
					  }).jstree({ 
						"plugins" : [ "core", "json_data", "themes", "ui", "dnd", "crrm" ],
						'core' : {
							'data' : json_category_tree,
							'check_callback' : true
						}
					}).bind("loaded.jstree", function (event, data) {
						// you get two params - event & data - check the core docs for a detailed description
						$(this).jstree("open_all");
					}).bind("move_node.jstree", function(e, data){
						$.post(
							window.location.href.toString()+"/move/"+data.node.id,
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
    
@stop



