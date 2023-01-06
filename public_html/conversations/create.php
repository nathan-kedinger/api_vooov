<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // Change with good method
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Verification that used method is correct
if($_SERVER['REQUEST_METHOD'] == 'POST'){ // Change with good method
    // Including files for config and data access
    include_once '../../Database.php';
    include_once '../models/CRUD.php';
    include_once '../tabs/tabs.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();
    $table = "conversations"; // Change with the good BDD table name

    // Datas
    $arguments = $tabConversations;// Replace with the good tab

    // SQL request
    $sql = "INSERT INTO " . $table . " SET ". implode(', ', array_map(function($argument) 
    { return $argument . '=:' . $argument; }, $arguments)); 

    // Records instanciation
    $conversation = new CRUD($db);

    // Get back sended informations
    $datas = json_decode(file_get_contents("php://input"));

    foreach($arguments as $argument){
        if(isset($datas->$argument)){
            //here we receive datas, we hydrate our object
            $conversation->$argument = $datas->$argument;
        }else{
            // We catch the mistake
            http_response_code(400);
            echo json_encode(["message" => "Arguments doesn't match"]);
        }
    }
    if($conversation->create($arguments, $sql)){
        // Here it worked => code 201
        http_response_code(201);
        echo json_encode(["message" => "The add have been done"]);
    }else{
        // Here it didn't worked => code 503
        http_response_code(503);
        echo json_encode(["message" => "The add haven't been done"]);
    }
}else{
    // We catch the mistake
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);
}