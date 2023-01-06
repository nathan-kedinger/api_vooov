<?php
class CRUD{
    // Connection
    private $connection;

    // Columns
    public $uuid;

    /**
     * Constructor with $db for db connection
     * 
     * @param $db
     */

     public function __construct($db)
     {
        $this->connection = $db;
     }


     /**
      * Creating user 
      *
      *@return void
      */
     public function create($arguments, $sql){

        try{
            // Request preparation
            $query = $this->connection->prepare($sql);

            // Protection from injections
            foreach($arguments as $argument){
                $this->$argument=htmlspecialchars(strip_tags($this->$argument));
            }

            // Adding protected datas
            foreach($arguments as $argument){
                $query->bindParam(":". $argument, $this->$argument);
            }

            // Request's execution
            $query->execute();
            // If there are no exceptions, return true
                return true;
        } catch (PDOException $e) {
            // If there is an exception, print exception's message and return false
            echo $e->getMessage();
            return false;
        }
     }


    /**
     * Reading users
     *
     *@return $query
     */
    public function read($sql){

        // Request preparation
        $query = $this->connection->prepare($sql);

        $query->execute();

        //return the result
        return $query;
    }


    /**
     * Reading one user
     * 
     * @return void
     * 
     */
    public function readOne($arguments, $sql){

        $query =$this->connection->prepare($sql);

        $query->bindParam(1, $this->uuid);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        foreach($arguments as $argument){
            $this->$argument = $row[$argument];
        }
    }


    /**
     * Update user
     * 
     * @return void
     * 
     */
    public function update($arguments, $sql){

        try{
            // Request preparation
            $query = $this->connection->prepare($sql);

            // Protection from injections
            foreach($arguments as $argument){
                $this->$argument=htmlspecialchars(strip_tags($this->$argument));
            }

            // Adding protected datas
            foreach($arguments as $argument){
                $query->bindParam(":". $argument, $this->$argument);
            }

            // Request's execution
            $query->execute();
            // If there are no exceptions, return true
                return true;
        } catch (PDOException $e) {
            // If there is an exception, print exception's message and return false
            echo $e->getMessage();
            return false;
        }
    }


    /**
     * Delete user
     * 
     * @return void
     * 
     */
    public function delete($sql){

        $query = $this->connection->prepare($sql);

        $this->uuid=htmlspecialchars(strip_tags($this->uuid));

        $query->bindParam(1, $this->uuid);

        if($query->execute()){
            return true;
        }

        return false;
    }
}