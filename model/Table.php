<?php

namespace Model;

class Table 
{
	private $connection;
	private $database;
	
	const DESCRIBE_NAME = 1;
	const DESCRIBE_ALL  = 2;
	
	public function __construct(\PDO $connection)
	{
		$this->connection = $connection;
		//$this->database   = $data;
	}
	
	public function fetchAll($table)
	{
		$stmt = $this->connection->query("select * from $table");
		
		return $stmt->fetchAll(\PDO::FETCH_NUM);
	}
	
	public function get()
	{
		$stmt = $this->connection->query("show tables");
		$res = [];
		
		while($row = $stmt->fetch(\PDO::FETCH_NUM))
		{
			$res[] = $row[0];
		}
		
		return $res;
	}
	
	public function add($options)
	{
		if(!isset($options['name']))
			return false;
		else if ($this->check($options['name']))
			return false;
		else 
			$name = $options['name'];
		
		if(!isset($options['engine']))
			$engine = 'MyIsam';
		else
			$engine = $options['engine'];
		
		if(!isset($options['row']))
			return false;
			
		$row = "";
		
		foreach ($options['row'] as $key => $value)
		{
			foreach ($value as $key2 => $value2)
			{
				$row .= $value2 . " ";
			}
			$row .= ", ";
		}
		
		$row = rtrim($row, ", ");
		
		$query = "create table $name ( $row ) Engine=$engine";
		
		$this->connection->query($query);
		return true;
	}
	
	public function rename($old, $new)
	{
		$old_exists = $this->check($old);
		$new_exists = $this->check($new);
			
		if ($old_exists == true && $new_exist == false) {
			$this->connection->query("alter table $old rename $new");
			return true;
		} else {
			return false;
		}
	}
	
	public function delete($name)
	{
		try {
			$this->connection->query('drop table ' . $name);
			return true;
		} catch (\Exception $e) {
			return false;
		}
	}
	
	public function check($name)
	{
		foreach ($this->get() as $key => $value)
			if( $value == $name )
				return true;
			
		return false;
	}
	
	public function describe($name, $type = self::DESCRIBE_ALL)
	{
		$res = $this->connection->query("describe $name");
		$res = $res->fetchAll(\PDO::FETCH_NUM);
		
		$result = [];
		
		if ($type == self::DESCRIBE_ALL) {
			return $res;
		} else if ($type == self::DESCRIBE_NAME) {
			foreach ($res as $value) {
				$result[] = $value[0];
			}
			return $result;
		}
	}
}