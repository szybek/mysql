<?php

namespace Core;

class View
{
	public function __construct($arr)
	{
		foreach($arr as $key => $value)
			$this->{$key} = $value;
	}

	public function render($controller, $file)
	{
		include("../view/$controller/$file.phtml");
	}
}