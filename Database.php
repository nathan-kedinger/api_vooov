<?php

class Database{
    private $host = "localhost";
    private $db_name = "api_vooov";
    private $username = "root";
    private $password = "";
    public $connection;

    //getter for connection
    public function getConnection(){
        //closing the connection if exists
        $this->connection = null; 

        // try to connect
        try{
            $this->connection = new PDO("mysql:host=" . $this->host . "dbname=" . $this->db_name, $this->username, $this->password);
            $this->connection->exec("set names utf8");  // force transaction in <UTF-8></UTF-8>
        }catch(PDOException $exception){
            echo "Erreur de connexion : " . $exception->getMessage(); 
        }

        return $this->connection;
    }
}
