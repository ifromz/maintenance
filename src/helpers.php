<?php
    
        /**
         * Returns a single lined path for a baum node
         * 
         * @param type $node
         * @return type
         */
	function renderNode($node)
        {
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
	function currentControllerAction($method)
        {
		$class =  explode('@', \Route::currentRouteAction());
		
		return sprintf('%s@%s', $class[0], $method);
	}
        
        /**
         * A helper alias for returning the current route name
         * 
         * @return string
         */
        function currentRouteName()
        {
            return Route::currentRouteName();
        }
        
        /**
         * A helper alias for returning the current request url
         * 
         * @return string
         */
        function currentUrl()
        {
            return Request::url();
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
        function link_to_sort($name, $title, $parameters)
        {
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
        
        /**
         * Helper for config facade. Checks if config helper function already exists
         * for Laravel 5 support
         * 
         * @param string $key
         * @param string $default
         * @return mixed (array or string)
         */
        if(!function_exists('config'))
        {
            function config($key, $default = NULL)
            {
                return Config::get($key, $default);
            }
        }
        
        /**
         * Helper for view facade. Checks if view helper function already exists
         * for Laravel 5 support
         * 
         * @param string $view
         * @param array $data
         * @param array $mergeData
         * @return mixed
         */
        if(!function_exists('view'))
        {
            function view($view, $data = array(), $mergeData = array())
            {
                return View::make($view, $data, $mergeData);
            }
        }
        
        /**
         * Helper for redirect facade. Checks if redirect helper function already exists
         * for Laravel 5 support 
         */
        if(!function_exists('redirect'))
        {
            function redirect($to)
            {
                return Redirect::to($to);
            }
        }
        
        