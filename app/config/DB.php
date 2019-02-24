<?php

/**
 * singleton class DB
 * 
 * 
 * @author Mario Marković
 */

class DB 
{
	private $servername;
	private $username;
	private $password;
	private	$dbname;
	private	$charset;

	private static $instance = null;
	private $db;

	private $results = [];
	private $result;
	private $lastInsertedId;
	private $count = 0;

	private function __construct()
	{
		$this->servername = "localhost";
		$this->username = "root";
		$this->password = "";
		$this->dbname = "blog_rest";
		$this->charset = "utf8mb4";

		try {
			$dsn = "mysql:host=".$this->servername.";dbname=" . $this->dbname . ";charset=". $this->charset;
			$pdo = new PDO($dsn, $this->username, $this->password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$this->db = $pdo;
		} catch (PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
			die();
		}
	}

	public static function connection()
	{
		if(!isset(self::$instance)) {
			self::$instance = new DB();
		}
		return self::$instance;
	}

	public function select($sql, array $params = [])
	{
		if(empty($params)) {
			$stmt = $this->db->query($sql);
			while($row = $stmt->fetchAll(PDO::FETCH_OBJ)) {
				$this->results = $row;
			}
			$this->count = $stmt->rowCount();
		} else {
			$stmt = $this->db->prepare($sql);
			$stmt->execute($params);
			while($row = $stmt->fetchAll(PDO::FETCH_OBJ)) {
				$this->results[] = $row;
			}
			$this->count = $stmt->rowCount();
		}

		return $this;// returns this object, so we can access getResults() and other public methods 
	}

	public function selectOne($sql, array $params = [])
	{
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params);
		$this->result = $stmt->fetch(PDO::FETCH_OBJ);

		return $this; 
	}

	public function insert($sql, array $params = [])
	{
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params);
		$this->lastInsertedId = $this->db->lastInsertId();

		return $this;
	}

	public function update($sql, array $params = []) 
	{
		$stmt = $this->db->prepare($sql);
		if($stmt->execute($params)) {
			return true;
		} else {
			return false;
		}
	}

	public function delete($sql, array $params = [])
	{
		$stmt = $this->db->prepare($sql);
		if($stmt->execute($params)) {
			return true;
		} else {
			return false;
		}
	}

	public function getResults()
	{
		return $this->results;
	}

	public function getResult()
	{
		return $this->result;
	}

	public function getLastInsertedId()
	{
		return $this->lastInsertedId;
	}

	public function getCount() 
	{
		return $this->count;
	}
}
