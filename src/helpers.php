<?php

	function renderNode($node){
		$html = '';
                
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
        }
	
	function currentControllerAction($method){
		$class =  explode('@', \Route::currentRouteAction());
		
		return sprintf('%s@%s',$class[0], $method);
	}