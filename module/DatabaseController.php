<?php

namespace Database;

use Core\ActionController;
use Model\Database;
use Model\Table;

class DatabaseController extends ActionController 
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	/*public function indexAction() 
	{
		$data = new Database($this->pdo);
		
		return array( "title" => "baza danych" );
	}*/
	
	public function showAction($data = false)
	{
		if(!$data)
			return false;
		
		if ($_SESSION['dbname'] != $data) {
			$_SESSION['dbname'] = $data;
			header('Location: '.$_SERVER['REQUEST_URI']);
		}
		
		$database = new Database($this->pdo);
		$table = new Table($this->pdo);
		
		return array( "title" => $data, "tables" => $table->get() );
	}
	
	/*public function renameAction($data)
	{
		if(!$data)
			return false;
		
		$database = new Database($this->pdo);
		
		if(!$database->check($data))
			return false;
		
  		if (isset($_POST['database'])) {
  			$database->
  			
  		}
  			
		
		return array();
	}*/
}