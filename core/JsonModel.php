<?php

namespace Core\Model;

class JsonModel 
{
	public function __construct($arr)
	{
		$this->arr = $arr;
	}
	
	public function render()
	{
		header('Content-Type: application/json');
		echo json_encode($this->arr);
	}
}