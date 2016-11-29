<?php

namespace Home;

use Core\ActionController;
use Model\Database;
use Model\Configuration;

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
		
		//$config = new Configuration();
		
		$databases = $data->get();
		
		/*foreach ($config->getHiddenDatabases() as $key => $value) {
			if (($res = array_search($value, $databases)) >= 0) {
				unset($databases[$res]);
			}
		}*/
		
		return array("title" => "MyDatabase", "databases" => $databases);
	}
	
	public function loginAction()
	{
		if (!file_exists(__DIR__ . '/../config/config.php')) {
			if(isset($_POST['user']))
				$_SESSION['user'] = $_POST['user'];
			if(isset($_POST['password']))
				$_SESSION['password'] = $_POST['password'];
		
			if (isset($_POST['user']) && isset($_POST['password'])) {
				$file = fopen(__DIR__ . '/../config/config.php', 'w');
				fwrite($file, "<?php\n");
				fwrite($file, "define('DB_USER', '" . $_POST['user'] . "');\n");
				fwrite($file, "define('DB_PASSWORD', '" . $_POST['password'] . "');\n");
				fwrite($file, "define('DB_HOST', 'localhost');\n");
				fwrite($file, "define('DB_NAME', '');\n");
				fclose($file);
				header("Location: http://" . $_SERVER['HTTP_HOST']);
			}
			
			return array('view' => "login");
		} else {
			require_once __DIR__ . '/../config/config.php';
			$_SESSION['user'] = DB_USER;
			$_SESSION['password'] = DB_PASSWORD;
			$_SESSION['dbname'] = DB_NAME;
			
			header("Location: http://" . $_SERVER['HTTP_HOST']);
		}
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