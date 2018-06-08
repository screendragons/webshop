<?php

Class DB {

	private $connection	= null;
	private $class = null;
	private $host = 'localhost';
	private $database = 'webshop-complete';
	private $username = 'root';
	private $password = 'root';
	private $port = 3306;
	private $query = '';
	private $select = '';
	private $arguments = '';
	private $orders = [];
	private $limit = false;

	// connect to the DB
	public function __construct()
	{
		try {
			$this->connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e) {
			dd($e->getMessage());
		}

		return $this;
	}

	// start a query
	public function query($insert, $arguments = [])
	{
		// reset the values
		$this->orders = [];
		$this->limit = false;

		$this->select = $insert;
		$this->arguments = $arguments;
		return $this;
	}

	// limit the amount of return values
	public function limit(int $amount)
	{
		$this->limit = $amount;

		return $this;
	}

	// put order by in the query (multiple)
	public function orderBy($column, $direction = 'ASC')
	{
		array_push($this->orders, [$column, $direction]);

		return $this;
	}

	// return all records based on query
	public function select($class)
	{
		include_once 'db/'.$class.'.php';

		try {
			$result = $this->connection->prepare($this->buildQuery());
			$result->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class);
			$result->execute($this->arguments);

			return $result->fetchAll();
		}
		catch(PDOException $e) {
			dd($e->getMessage());
		}
	}

	// return only the first record based on query
	public function first($class)
	{
		include_once 'db/'.$class.'.php';

		try {
			$this->limit(1);
			$result = $this->connection->prepare($this->buildQuery());
			$result->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class);
			$result->execute($this->arguments);

			return $result->fetch();
		}
		catch(PDOException $e) {
			dd($e->getMessage().':'.$this->buildQuery());
		}
	}

	// run an update
	public function update()
	{
		try {
			$result = $this->connection->prepare($this->buildQuery());
			return $result->execute($this->arguments);
		}
		catch(PDOException $e) {
			dd($e->getMessage());
		}
	}

	// run an insert
	public function insert()
	{
		try {
			$result = $this->connection->prepare($this->buildQuery());
			$result->execute($this->arguments);
			return $this->connection->lastInsertId();
		}
		catch(PDOException $e) {
			dd($e->getMessage());
		}
	}

	// run a delete
	public function delete()
	{

	}

	// build the query
	private function buildQuery()
	{
		$query = $this->select;

		if(count($this->orders)) {
			$query .= ' ORDER BY ';

			$order = [];

			foreach ($this->orders as $values) {
				array_push($order, $values[0].' '.$values[1]);
			}
			$query .= implode(', ', $order);
		}

		if($this->limit) {
			$query .= ' LIMIT '.$this->limit;
		}

		$this->query = $query;

		return $this->query;
	}

	// start a transaction
	public function transaction()
	{
		$this->connection->beginTransaction();
	}

	// commit a transaction
	public function commit()
	{
		$this->connection->commit();
	}

	// roll back a transaction
	public function rollBack()
	{
		$this->connection->rollBack();
	}

}
