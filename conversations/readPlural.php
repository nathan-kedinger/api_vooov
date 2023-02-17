<?php
    // Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
include_once '../tabs/tabs.php';

    // Expected table
    $table = "conversations";

    // Datas
    $arguments = $tabConversations;// Replace with the good tab

    // SQL request
    $sql = "SELECT " . implode(', ', array_map(function($argument) 
    {return $argument;}, $arguments)) . " FROM " . $table . " WHERE 
    sender = ? OR receiver = ?"; // It is possible to add a join after that

    try{
        /**
        * Script to handle a GET request
        *
        * @throws InvalidArgumentException if the request method is not GET
        */
        // Verification that used method is correct
    
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] != 'GET'){
            throw new Exception("Invalid request method. Only GET is allowed", 405);
        }
        // Including files for config and data access
        include_once '../../Database.php';
        include_once '../models/CRUD.php';
    
        // DDB instanciation
        $database = new Database();
        $db = $database->getConnection();
    
        // crudObject instanciation
        $crudObject = new CRUD($db);
    
        // Get datas
        $stmt = $crudObject->readPlural($sql, [$_GET["sender"], $_GET["receiver"]]);

        // Verifying that we have at least one row in database
        if($stmt->rowCount() > 0){
            //initialisation of an associative tab
            $showedDatas = array();
    
            // $table = DB table
            $data = array();
    
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data = array();
                foreach($arguments as $argument){
                    $data[$argument] = $row[$argument];
                }
                $showedDatas[] = $data;
            }
            http_response_code(200);
    
            echo json_encode($showedDatas);
        }else{
            http_response_code(400);
            echo json_encode(["message" => "There is no row in that table"]);
        }
    
} catch (Exception $e){
    http_response_code($e->getCode());
    echo json_encode(["Message" => $e->getMessage()]);
    error_log($e->getMessage());
}