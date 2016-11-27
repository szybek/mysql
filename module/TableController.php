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
	
	public function deleteAction($name = false)
	{
		if (!$name) {
			return false;
		} else {
			$data = new Table($this->pdo);
			$res = $data->check($name);
			if (!$res) {
				return array('delete' => false, 'reason' => 'Nie ma takiej tabeli');
			} else {
				if ($data->delete($name)) {
					return array('delete' => true);
				} else {
					return array('delete' => false);
				}
			}
		}
	}
}