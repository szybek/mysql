<?php

namespace Core;

class ActionController extends Controller  
{
	public function dispatch($action, $id)
	{
		if (method_exists($this, $action . "Action")) {
			$res = $this->{$action . "Action"}($id);
		 	return $res;
		} else {
			return 0;
		}
	}
}