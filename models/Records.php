<?php
class Records{
    // Connection
    private $connection;
    private $table = "records"; // Table in database

    // Columns
    public $uuid;
    public $artist_uuid;
    public $title;
    public $number_of_play;
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
        $sql = "INSERT INTO " . $this->table . " t1 INNER JOIN users t2 ON t1.artist_uuid = t2.uuid
        SET t1.artist_uuid=:artist_uuid, t1.title=:title, t1.number_of_play=:number_of_play, 
        t1.number_of_moons:=number_of_moons, t1.voice_style=:voice_style, 
        t1.kind=:kind, t1.description=:description, t1.created_at=:created_at, t1.updated_at=:updated_at";
        
        
        /*"
        SET artist_uuid=:artist_uuid, title=:title, 
        number_of_play=:number_of_play, number_of_moons:=number_of_moons, voice_style=:voice_style, 
        kind=:kind, description=:description, created_at=:created_at, updated_at=:updated_at";*/

        // Request preparation
        $query = $this->connection->prepare($sql);

        // Protection from injections
        $this->artist_uuid=htmlspecialchars(strip_tags($this->artist_uuid));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->number_of_play=htmlspecialchars(strip_tags($this->number_of_play));
        $this->number_of_moons=htmlspecialchars(strip_tags($this->number_of_moons));
        $this->voice_style=htmlspecialchars(strip_tags($this->voice_style));
        $this->kind=htmlspecialchars(strip_tags($this->kind));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));
        $this->updated_at=htmlspecialchars(strip_tags($this->updated_at));

        // Adding protected datas
        $query->bindParam(":artist_uuid", $this->artist_uuid);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":number_of_play", $this->number_of_play);
        $query->bindParam(":number_of_moons", $this->number_of_moons);
        $query->bindParam(":voice_style", $this->voice_style);
        $query->bindParam(":kind", $this->kind);
        $query->bindParam(":description", $this->description);
        $query->bindParam(":created_at", $this->created_at);
        $query->bindParam(":updated_at", $this->updated_at);

        // Request's execution
        if($query->execute()){
            return true;
        }
        return false;
     }


    /**
     * Reading users
     *
     *@return $query
     */
    public function read(){
        
        $sql = "SELECT * FROM " . $this->table ."";

/*$sql = "SELECT u.uuid, u.artist_uuid, u.title,u.number_of_play, u.number_of_moons, u.kind, u.description,
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
        
        $sql = "SELECT u.uuid, u.artist_uuid, u.title,u.number_of_play, u.number_of_moons,
        u.voice_style, u.kind, u.description, u.created_at, u.updated_at FROM " . $this->table ." AS u
        WHERE u.uuid = ? LIMIT 0,1";

        $query =$this->connection->prepare($sql);

        $query->bindParam(1, $this->uuid);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->artist_uuid = $row['artist_uuid'];
        $this->title = $row['title'];
        $this->number_of_play = $row['number_of_play'];
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
        
        $sql = "UPDATE " . $this->table . " SET artist_uuid=:artist_uuid, title=:title, number_of_play=:number_of_play, 
        number_of_moons:=number_of_moons, voice_style=:voice_style, kind=:kind,
        description=:description, created_at=:created_at, updated_at=:updated_at WHERE uuid = :uuid";
        
        $query = $this->connection->prepare($sql);

        // Protection from injections
        $this->artist_uuid=htmlspecialchars(strip_tags($this->artist_uuid));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->number_of_play=htmlspecialchars(strip_tags($this->number_of_play));
        $this->number_of_moons=htmlspecialchars(strip_tags($this->number_of_moons));
        $this->voice_style=htmlspecialchars(strip_tags($this->voice_style));
        $this->kind=htmlspecialchars(strip_tags($this->kind));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));
        $this->updated_at=htmlspecialchars(strip_tags($this->updated_at));

        // Adding protected datas
        $query->bindParam(":artist_uuid", $this->artist_uuid);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":number_of_play", $this->number_of_play);
        $query->bindParam(":number_of_moons", $this->number_of_moons);
        $query->bindParam(":voice_style", $this->voice_style);
        $query->bindParam(":kind", $this->kind);
        $query->bindParam(":description", $this->description);
        $query->bindParam(":created_at", $this->created_at);
        $query->bindParam(":updated_at", $this->updated_at);

        // Request's execution
        if($query->execute()){
            return true;
        }
        return false;        

    }
    
}