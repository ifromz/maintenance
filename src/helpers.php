<?php
    
        /**
         * Returns a single lined path for a baum node
         * 
         * @param type $node
         * @return type
         */
	function renderNode($node){
		$html = '';
                
                if(is_object($node)){
                    $ancestors = $node->getAncestorsAndSelf();

                    foreach($ancestors as $ancestor){
                            if($node->equals($ancestor) && $node->isRoot()){
                                    $html .= sprintf('<b>%s</b>', $ancestor->name);
                            } elseif($node->equals($ancestor)){
                                    $html .= sprintf(' > <b>%s</b>', $ancestor->name);
                            } elseif($ancestor->isRoot()){
                                    $html .= sprintf('%s', $ancestor->name);
                            } else{
                                    $html .= sprintf(' > %s', $ancestor->name);
                            }
                    }

                    return $html;
                } return $node;
        }
	
        /**
         * Returns a controller action for the current in use controller.
         * This is used for nested set category/location management
         * 
         * @param type $method
         * @return type
         */
	function currentControllerAction($method){
		$class =  explode('@', \Route::currentRouteAction());
		
		return sprintf('%s@%s',$class[0], $method);
	}
        
        /**
         * Returns a link to sort a table column with the query scope 'sort'
         * 
         * @param type $name
         * @param type $title
         * @param type $parameters
         * @param type $icon
         * @return type
         */
        function link_to_sort($name, $title, $parameters){
            $field = Input::get('field');
            $sort = Input::get('sort');
            
            if($sort == 'desc'){
                $parameters['sort'] = 'asc';
            } else{
                $parameters['sort'] = 'desc';
            }
            
            if($field == $parameters['field']){
                $icon = sprintf('fa %s-%s', 'fa-sort', $parameters['sort']);
            } else{
                $icon = sprintf('fa %s', 'fa-sort');
            }
            
            return sprintf('<a href="%s">%s <i class="%s"></i></a>', route($name, $parameters), $title, $icon);
        }