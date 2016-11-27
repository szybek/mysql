<?php

namespace Table;

use Core\ActionController;
use Model\Table;
use Model\Database;

class TableController extends ActionController 
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function showAction($data = false)
	{
		if(!$data)
			return false;
				
		$database = new Database($this->pdo);
		$database->change($data);
		
		$table = new Table($this->pdo);
		
		return array( "title" => $data, "rows" => $table->fetchAll($data), 'description' => $table->describe($data, Table::DESCRIBE_NAME));
	}
	
	public function addAction()
	{
		
	}
}