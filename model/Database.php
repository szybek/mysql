<?php

namespace Model;

class Database
{
	public $connection;
	
	public function __construct(\PDO $connection)
	{
		$this->connection = $connection;
	}
	
	public function get()
	{
		$stmt = $this->connection->query('show databases');
		$res = [];
		while($row = $stmt->fetch(\PDO::FETCH_NUM))
			$res[] = $row[0];
		return $res;
	}
	
	public function getName()
	{
		$stmt = $this->connection->query('select database()')->fetch(\PDO::FETCH_NUM);
		return $stmt[0];
	}
	
	public function add($name)
	{
		try {
			$this->connection->query('create database ' . $name);
			if ($this->check($name))
				return true;
			else 
				return false;
		} catch (\Exception $e) {
			return false;
		}
	}
	
	public function delete($name)
	{
		try {
			$this->connection->query('drop database ' . $name);
			return true;
		} catch (\Exception $e) {
			return false;
		}
	}
	
	public function change($name)
	{
		try {
			$this->connection->query('use ' . $name);
			return true;
		} catch (\Exception $e) {
			return false;
		}
	}
	
	public function check($name)
	{
		$datas = $this->get();
		foreach ($datas as $value)
			if($value == $name)
				return true;
			
		return false;
	}
}