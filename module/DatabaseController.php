<?php

namespace Database;

use Core\ActionController;
use Core\Model\ViewModel;
use Core\Model\JsonModel;
use Model\Database;
use Model\Table;

class DatabaseController extends ActionController 
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
		
		if ($_SESSION['dbname'] != $data) {
			$_SESSION['dbname'] = $data;
			header('Location: '.$_SERVER['REQUEST_URI']);
		}
		
		$database = new Database($this->pdo);
		$table = new Table($this->pdo);
		
		return array( "title" => $data, "tables" => $table->get());
	}
	
	public function addAction()
	{
		if (isset($_POST['database'])) {
			
			$name = strtolower($_POST['database']);
			
			$data = new Database($this->pdo);
			$res = $data->check($name);
			
			if ($res) {
				$arr = array('create' => false, 'reason' => 'Ta nazwa już istnieje');
				if (isset($_POST['ajax']) && $_POST['ajax'] == true)
					return new JsonModel($arr);
				else
					return $arr;
			} else {
				$result = $data->add($name);
				if ($result) {
					$arr = array('create' => true, 'name' => $name);
					if (isset($_POST['ajax']) && $_POST['ajax'] == true)
						return new JsonModel($arr);
					else
						return $arr;
				} else {
					if (isset($_POST['ajax']) && $_POST['ajax'] == true)
						return new JsonModel(array('create' => false));
					else
						return array('create' => false);
				}
			}
			
		}
		
		return false;
	}
	
	public function deleteAction($name = false)
	{
		if (!$name) {
			return false;
		} else {
			$data = new Database($this->pdo);
			$res = $data->check($name);
			if ($res) {
				$_SESSION['dbname'] = '';
				$data->delete($name);
				if (isset($_POST['ajax']) && $_POST['ajax'] == true)
					return new JsonModel(array('delete' => true, 'name' => $name));
				else
					return array('delete' => true);
			} else {
				if (isset($_POST['ajax']) && $_POST['ajax'] == true)
					return new JsonModel(array('delete' => false));
				else
					return array('delete' => false);
			}
		}
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