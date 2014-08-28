<?php

	function renderNode($node){
		$html = '';
		
		$ancestors = $node->getAncestorsAndSelf();
		
		foreach($ancestors as $ancestor){
			if($ancestors[0]->name == $ancestor->name){
				$html .= $ancestor->name;
			} else{
				$html .= ' > '.$ancestor->name;
			}
		}
		
		return $html;
        }
	
	function currentControllerAction($method){
		$class =  explode('@', \Route::currentRouteAction());
		
		return sprintf('%s@%s',$class[0], $method);
	}