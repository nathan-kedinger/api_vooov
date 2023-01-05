<?php
class Messages{
    // Connection
    private $connection;
    private $table = "messages"; // Table in database

    // Columns
    public $uuid;
    public $sender;
    public $receiver;
    public $body;
    public $seen;
    public $send_at;


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
     public function create(){

        // Writting SQL request by insering table's name
        $sql = "INSERT INTO " . $this->table . " m INNER JOIN users u ON m.sender = u.uuid
        SET m.uuid=:uuid, m.sender=:sender, m.receiver=:receiver, m.body=:body, 
        m.seen=:seen, m.send_at=:send_at";

        try{
            // Request preparation
            $query = $this->connection->prepare($sql);

            // Protection from injections
            $this->uuid=htmlspecialchars(strip_tags($this->uuid));
            $this->sender=htmlspecialchars(strip_tags($this->sender));
            $this->receiver=htmlspecialchars(strip_tags($this->receiver));
            $this->body=htmlspecialchars(strip_tags($this->body));
            $this->seen=htmlspecialchars(strip_tags($this->seen));
            $this->send_at=htmlspecialchars(strip_tags($this->send_at));

            // Adding protected datas
            $query->bindParam(":uuid", $this->uuid);
            $query->bindParam(":sender", $this->sender);
            $query->bindParam(":receiver", $this->receiver);
            $query->bindParam(":body", $this->body);
            $query->bindParam(":seen", $this->seen);
            $query->bindParam(":send_at", $this->send_at);

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
    public function read(){
        
        $sql = "SELECT * FROM " . $this->table ."";

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
    public function readOne(){
        
        $sql = "SELECT m.uuid, m.sender, m.receiver, m.body, m.seen,
        m.send_at FROM " . $this->table ." AS m
        WHERE m.uuid = ? LIMIT 0,1";

        $query =$this->connection->prepare($sql);

        $query->bindParam(1, $this->uuid);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->sender = $row['sender'];
        $this->receiver = $row['receiver'];
        $this->body = $row['body'];
        $this->seen = $row['seen'];
        $this->send_at = $row['send_at'];

    }


    /**
     * Delete user
     * 
     * @return void
     * 
     */
    public function delete(){
        
        $sql = "DELETE FROM " . $this->table ." WHERE uuid = ?";

        $query = $this->connection->prepare($sql);

        $this->uuid=htmlspecialchars(strip_tags($this->uuid));

        $query->bindParam(1, $this->uuid);

        if($query->execute()){
            return true;
        }

        return false;
    }


    /**
     * Update user
     * 
     * @return void
     * 
     */
    public function update(){
        
        $sql = "UPDATE " . $this->table . " SET sender=:sender, receiver=:receiver, body=:body, 
        seen=:seen, send_at=:send_at WHERE uuid = :uuid";
        

        try{
            $query = $this->connection->prepare($sql);

            // Protection from injections
            $this->sender=htmlspecialchars(strip_tags($this->sender));
            $this->receiver=htmlspecialchars(strip_tags($this->receiver));
            $this->body=htmlspecialchars(strip_tags($this->body));
            $this->seen=htmlspecialchars(strip_tags($this->seen));
            $this->send_at=htmlspecialchars(strip_tags($this->send_at));

            // Adding protected datas
            $query->bindParam(":sender", $this->sender);
            $query->bindParam(":receiver", $this->receiver);
            $query->bindParam(":body", $this->body);
            $query->bindParam(":seen", $this->seen);
            $query->bindParam(":send_at", $this->send_at);

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
    
}