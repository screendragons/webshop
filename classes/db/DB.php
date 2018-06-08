<?php

Class DB {

    private $connection    = null;
    private $class = null;
    private $host = 'localhost';
    private $database = 'webshop';
    private $username = 'root';
    private $password = '';
    private $port = 3306;
    private $query = '';
    private $select = '';
    private $arguments = '';
    private $orders = [];
    private $limit = false;

    public function __construct($class)
    {
        $this->class = $class;
        include_once 'db/'.$class.'.php';

        try {
            $this->connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            dd($e->getMessage());
        }

        return $this;
    }


    public function select($select, $arguments = [])
    {
        $this->select = $select;
        $this->arguments = $arguments;
        return $this;
    }


    public function limit(int $amount)
    {
        $this->limit = $amount;

        return $this;
    }


    public function orderBy($column, $direction = 'ASC')
    {
        array_push($this->orders, [$column, $direction]);

        return $this;
    }


    public function get()
    {
        try {
            $result = $this->connection->prepare($this->buildQuery());
            $result->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->class);
            $result->execute($this->arguments);

            return $result->fetchAll();
            // setFetchMode(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            dd($e->getMessage());
        }
    }


    public function first()
    {
        try {
            $result = $this->connection->prepare($this->buildQuery());
            $result->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->class);
            $result->execute($this->arguments);

            return $result->fetch();
            // setFetchMode(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            dd($e->getMessage().':'.$this->buildQuery());
        }
    }


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

}
