<?php

namespace Model;

class Configuration
{
	private $pdo;
	
	public function __construct()
	{
		$this->pdo = new \PDO('mysql:host=localhost;dbname=configuration_admin', 'root', '');
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}
	
	public function getHiddenDatabases()
	{
		$res = $this->pdo->query('select name from database_hidden');
		$res = $res->fetchAll(\PDO::FETCH_NUM);
		$result = [];
		foreach ($res as $value) {
			$result[] = $value[0];
		}
		return $result;
	}
}