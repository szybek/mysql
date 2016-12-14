<?php

namespace Bootstrap;

use \Core\View;
use \Core\Model\ViewModel;

session_start();

require_once('/../autoload.php');

//$_SESSION['user']     = 'root';
//$_SESSION['password'] = '';

//$_SESSION = array();
//session_destroy();

$url = explode("/", rtrim($_GET['url'], "/"));

if($url[0] == "")
    $module = "Home";
else
    $module = ucfirst($url[0]);

if(isset($url[1]))
	$action = $url[1];
else 
	$action = "index";

$id = false;
	
if(isset($url[2]))
	$id = $url[2];

$controller = $module . "\\" . $module . "Controller";

if (!class_exists($controller)) {
	echo "<h1>Strona nie istnieje</h1>";
	return;
} else {
	$pdo = false;
	if (isset($_SESSION['user']) && isset($_SESSION['password'])) {
		$pdo = new \PDO('mysql:host=localhost;dbname='.$_SESSION['dbname'], $_SESSION['user'], $_SESSION['password']);
		$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	} else {
    	if($module != "Home" || $action != "index")
    		header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
	}
	$core = new $controller($pdo);
}

$res = [];

$res = $core->dispatch($action, $id);

//echo get_class($res);
if (!is_object($res)) {
	if ($res != 0) {
		if (!!$res['view']) {
			$file = $res['view'];
			unset($res['view']);
		} else {
			$file = $action;
		}
		$view = new ViewModel($res);
		$view->render(strtolower($module), $file);
	} else {
		echo "<h1>Strona nie istnieje</h1>";
		return;
	}
} else {
	if (get_class($res) == "Core\Model\ViewModel") {
		if (!!$res->view) {
			$file = $res->view;
			unset($res->view);
		} else {
			$file = $action;
		}
		$view = new ViewModel($res);
		$view->render(strtolower($module), $file);
	} else if (get_class($res) == "Core\Model\JsonModel") {
		$res->render();
	}
}