<?php
class Records{
    // Connection
    private $connection;
    private $table = "audio_records"; // Table in database

    // Columns
    public $uuid;
    public $artist_uuid;
    public $title;
    public $length;
    public $number_of_plays;
    public $number_of_moons;
    public $voice_style;
    public $kind;
    public $description;
    public $created_at;
    public $updated_at;


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
        $sql = "INSERT INTO " . $this->table . "
        SET uuid=:uuid, artist_uuid=:artist_uuid, title=:title, length=:length, number_of_plays=:number_of_plays, 
        number_of_moons=:number_of_moons, voice_style=:voice_style, 
        kind=:kind, description=:description, created_at=:created_at, updated_at=:updated_at";

        try{
            // Request preparation
            $query = $this->connection->prepare($sql);

            // Protection from injections
            $this->uuid=htmlspecialchars(strip_tags($this->uuid));
            $this->artist_uuid=htmlspecialchars(strip_tags($this->artist_uuid));
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->length=htmlspecialchars(strip_tags($this->length));
            $this->number_of_plays=htmlspecialchars(strip_tags($this->number_of_plays));
            $this->number_of_moons=htmlspecialchars(strip_tags($this->number_of_moons));
            $this->voice_style=htmlspecialchars(strip_tags($this->voice_style));
            $this->kind=htmlspecialchars(strip_tags($this->kind));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->created_at=htmlspecialchars(strip_tags($this->created_at));
            $this->updated_at=htmlspecialchars(strip_tags($this->updated_at));

            // Adding protected datas
            $query->bindParam(":uuid", $this->uuid);
            $query->bindParam(":artist_uuid", $this->artist_uuid);
            $query->bindParam(":title", $this->title);
            $query->bindParam(":length", $this->length);
            $query->bindParam(":number_of_plays", $this->number_of_plays);
            $query->bindParam(":number_of_moons", $this->number_of_moons);
            $query->bindParam(":voice_style", $this->voice_style);
            $query->bindParam(":kind", $this->kind);
            $query->bindParam(":description", $this->description);
            $query->bindParam(":created_at", $this->created_at);
            $query->bindParam(":updated_at", $this->updated_at);

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

/*$sql = "SELECT u.uuid, u.artist_uuid, u.title,u.number_of_plays, u.number_of_moons, u.kind, u.description,
u.created_at, u.updated_at, u.voice_style, u., u. FROM " . $this->table ." AS u";*/

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
        
        $sql = "SELECT r.uuid, r.artist_uuid, r.title, r.length, r.number_of_plays, r.number_of_moons,
        r.voice_style, r.kind, r.description, r.created_at, r.updated_at FROM " . $this->table ." AS r
        WHERE r.uuid = ? LIMIT 0,1";

        $query =$this->connection->prepare($sql);

        $query->bindParam(1, $this->uuid);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->artist_uuid = $row['uuid'];
        $this->artist_uuid = $row['artist_uuid'];
        $this->title = $row['title'];
        $this->length = $row['length'];
        $this->number_of_plays = $row['number_of_plays'];
        $this->number_of_moons = $row['number_of_moons'];
        $this->voice_style = $row['voice_style'];
        $this->kind = $row['kind'];
        $this->description = $row['description'];
        $this->created_at = $row['created_at'];
        $this->updated_at = $row['updated_at'];

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
        
        $sql = "UPDATE " . $this->table . " SET uuid=:uuid, artist_uuid=:artist_uuid, title=:title, length=:length, number_of_plays=:number_of_plays, 
        number_of_moons=:number_of_moons, voice_style=:voice_style, kind=:kind,
        description=:description, created_at=:created_at, updated_at=:updated_at WHERE uuid = :uuid";
        
        try{
            $query = $this->connection->prepare($sql);

            // Protection from injections
            $this->uuid=htmlspecialchars(strip_tags($this->uuid));
            $this->artist_uuid=htmlspecialchars(strip_tags($this->artist_uuid));
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->length=htmlspecialchars(strip_tags($this->length));
            $this->number_of_plays=htmlspecialchars(strip_tags($this->number_of_plays));
            $this->number_of_moons=htmlspecialchars(strip_tags($this->number_of_moons));
            $this->voice_style=htmlspecialchars(strip_tags($this->voice_style));
            $this->kind=htmlspecialchars(strip_tags($this->kind));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->created_at=htmlspecialchars(strip_tags($this->created_at));
            $this->updated_at=htmlspecialchars(strip_tags($this->updated_at));

            // Adding protected datas
            $query->bindParam(":uuid", $this->uuid);
            $query->bindParam(":artist_uuid", $this->artist_uuid);
            $query->bindParam(":title", $this->title);
            $query->bindParam(":length", $this->length);
            $query->bindParam(":number_of_plays", $this->number_of_plays);
            $query->bindParam(":number_of_moons", $this->number_of_moons);
            $query->bindParam(":voice_style", $this->voice_style);
            $query->bindParam(":kind", $this->kind);
            $query->bindParam(":description", $this->description);
            $query->bindParam(":created_at", $this->created_at);
            $query->bindParam(":updated_at", $this->updated_at);

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