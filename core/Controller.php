<?php

namespace Core;

class Controller 
{	
	protected $param;
	
	public function dispatch($function, $id){}
	
	public function param($param, $value = false)
	{
		if(!$value)
		{
			return $this->param->{$param};
		}
		else
		{
			$this->param->{$param} = $value;
		}
	}
}