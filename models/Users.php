<?php
class Users{
    //connection
    private $connection;
    private $table = "users"; //table in database

    //columns
    public $id;
    public $name;
    public $email;
    public $phone;
    public $number_of_followers;
    public $number_of_friends;
    public $url_picture;
    public $created_at;
    public $description;


    /**
     * constructor with $db for db connection
     * 
     * @param $db
     */

     public function __construct($db)
     {
        $this->connection = $db;
     }

    /**
     * reading users
     *
     *@return void
     */
    public function read(){
        $sql = "SELECT id, "
    }
    
}