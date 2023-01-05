<?php
class Users{
    // Connection
    private $connection;
    private $table = "users"; // Table in database

    // Columns
    public $uuid;
    public $name;
    public $firstname;
    public $email;
    public $phone;
    public $description;
    public $number_of_followers;
    public $number_of_moons;
    public $number_of_friends;
    public $url_profile_picture;
    public $sign_in;
    public $last_connection;


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
        $sql = "INSERT INTO " . $this->table . " SET uuid=:uuid, name=:name, firstname=:firstname, email=:email, phone=:phone, description=:description, 
        number_of_followers=:number_of_followers, number_of_moons=:number_of_moons, number_of_friends=:number_of_friends, 
        url_profile_picture=:url_profile_picture, sign_in=:sign_in, last_connection=:last_connection";

        try{
            // Request preparation
            $query = $this->connection->prepare($sql);

            // Protection from injections
            $this->uuid=htmlspecialchars(strip_tags($this->uuid));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->firstname=htmlspecialchars(strip_tags($this->firstname));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->phone=htmlspecialchars(strip_tags($this->phone));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->number_of_followers=htmlspecialchars(strip_tags($this->number_of_followers));
            $this->number_of_moons=htmlspecialchars(strip_tags($this->number_of_moons));
            $this->number_of_friends=htmlspecialchars(strip_tags($this->number_of_friends));
            $this->url_profile_picture=htmlspecialchars(strip_tags($this->url_profile_picture));
            $this->sign_in=htmlspecialchars(strip_tags($this->sign_in));
            $this->last_connection=htmlspecialchars(strip_tags($this->last_connection));

            // Adding protected datas
            $query->bindParam(":uuid", $this->uuid);
            $query->bindParam(":name", $this->name);
            $query->bindParam(":firstname", $this->firstname);
            $query->bindParam(":email", $this->email);
            $query->bindParam(":phone", $this->phone);
            $query->bindParam(":description", $this->description);
            $query->bindParam(":number_of_followers", $this->number_of_followers);
            $query->bindParam(":number_of_moons", $this->number_of_moons);
            $query->bindParam(":number_of_friends", $this->number_of_friends);
            $query->bindParam(":url_profile_picture", $this->url_profile_picture);
            $query->bindParam(":sign_in", $this->sign_in);
            $query->bindParam(":last_connection", $this->last_connection);

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

/*$sql = "SELECT u.uuid, u.name, u.firstname,u.email, u.phone, u.number_of_followers, u.number_of_moons,
u.number_of_friends, u.url_profile_picture, u.description, u.sign_in, u.last_connection FROM " . $this->table ." AS u";*/

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
        
        $sql = "SELECT u.uuid, u.name, u.firstname,u.email, u.phone, u.description, u.number_of_followers, u.number_of_moons,
        u.number_of_friends, u.url_profile_picture, u.sign_in, u.last_connection FROM " . $this->table ." AS u
        WHERE u.uuid = ? LIMIT 0,1";

        $query =$this->connection->prepare($sql);

        $query->bindParam(1, $this->uuid);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->firstname = $row['firstname'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->description = $row['description'];
        $this->number_of_followers = $row['number_of_followers'];
        $this->number_of_moons = $row['number_of_moons'];
        $this->number_of_friends = $row['number_of_friends'];
        $this->url_profile_picture = $row['url_profile_picture'];
        $this->sign_in = $row['sign_in'];
        $this->last_connection = $row['last_connection'];

    }


    /**
     * Delete user
     * 
     * @return void
     * 
     */
    public function delete(){
        
        $sql = "DELETE FROM " . $this->table ." WHERE uuid = ?";

        try{
            $query = $this->connection->prepare($sql);

            $this->uuid=htmlspecialchars(strip_tags($this->uuid));

            $query->bindParam(1, $this->uuid);

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
     * Update user
     * 
     * @return void
     * 
     */
    public function update(){
        
        $sql = "UPDATE " . $this->table . " SET name=:name, firstname=:firstname, email=:email, phone=:phone, description=:description,
        number_of_followers=:number_of_followers, number_of_moons=:number_of_moons, number_of_friends=:number_of_friends, 
        url_profile_picture=:url_profile_picture, sign_in=:sign_in, last_connection=:last_connection WHERE uuid = :uuid";
        

        try{
            $query = $this->connection->prepare($sql);
            
            // Protection from injections
            $this->uuid=htmlspecialchars(strip_tags($this->uuid));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->firstname=htmlspecialchars(strip_tags($this->firstname));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->phone=htmlspecialchars(strip_tags($this->phone));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->number_of_followers=htmlspecialchars(strip_tags($this->number_of_followers));
            $this->number_of_moons=htmlspecialchars(strip_tags($this->number_of_moons));
            $this->number_of_friends=htmlspecialchars(strip_tags($this->number_of_friends));
            $this->url_profile_picture=htmlspecialchars(strip_tags($this->url_profile_picture));
            $this->sign_in=htmlspecialchars(strip_tags($this->sign_in));
            $this->last_connection=htmlspecialchars(strip_tags($this->last_connection));
            
            // Adding protected datas
            $query->bindParam(":uuid", $this->uuid);
            $query->bindParam(":name", $this->name);
            $query->bindParam(":firstname", $this->firstname);
            $query->bindParam(":email", $this->email);
            $query->bindParam(":phone", $this->phone);
            $query->bindParam(":description", $this->description);
            $query->bindParam(":number_of_followers", $this->number_of_followers);
            $query->bindParam(":number_of_moons", $this->number_of_moons);
            $query->bindParam(":number_of_friends", $this->number_of_friends);
            $query->bindParam(":url_profile_picture", $this->url_profile_picture);
            $query->bindParam(":sign_in", $this->sign_in);
            $query->bindParam(":last_connection", $this->last_connection);

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