<?php

namespace Home;

use Core\ActionController;
use Model\Database;

class HomeController extends ActionController
{
	private $pdo;
	
	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function indexAction() 
	{
		$data = new Database($this->pdo);
		
		return array("title" => "Działa", "databases" => $data->get());
	}
	
	public function loginAction()
	{
		if(isset($_POST['user']))
			$_SESSION['user'] = $_POST['user'];
		if(isset($_POST['password']))
			$_SESSION['password'] = $_POST['password'];
		
		if (isset($_POST['user']) && isset($_POST['password']))
			header("Location: http://" . $_SERVER['HTTP_HOST']);
			
		return array('view' => "login");
	}
	
	public function dispatch($action, $id)
	{
		if (!$this->pdo) {
			$res = $this->loginAction();
			return $res;
		}
		
		if ($action == "login")
			return 0;
		
		if (method_exists($this, $action . "Action")) {
			$res = $this->{$action . "Action"}($id);
			return $res;
		} else {
			return 0;
		}
	}
}