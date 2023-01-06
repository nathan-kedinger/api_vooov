<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// Verification that used method is correct
if($_SERVER['REQUEST_METHOD'] == 'PUT'){ // Change with good method
    // Including files for config and data access
    include_once '../../Database.php';
    include_once '../models/CRUD.php';
    include_once '../tabs/tabs.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();
    $table = "audio_records"; // Change with the good BDD table name


    // Datas
    $arguments = $tabRecords;// Replace with the good tab

    // SQL request
    $sql = "UPDATE " . $table . " SET ". implode(', ', array_map(function($argument) 
    { return $argument . '=:' . $argument; }, $arguments)) . " WHERE uuid=:uuid"; 

    // Records instanciation
    $records = new CRUD($db);

    // Get back sended informations
    $datas = json_decode(file_get_contents("php://input"));

    foreach($arguments as $argument){
        if(isset($datas->$argument)){
            //here we receive datas, we hydrate our object
            $records->$argument = $datas->$argument;
        }else{
            // We catch the mistake
            http_response_code(400);
            echo json_encode(["message" => "Arguments doesn't match"]);
        }
    }
    if($records->update($arguments, $sql)){
        // Here it worked => code 201
        http_response_code(201);
        echo json_encode(["message" => "The change have been done"]);
    }else{
        // Here it didn't worked => code 503
        http_response_code(503);
        echo json_encode(["message" => "The change haven't been done"]);
    }
}else{
    // We catch the mistake
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);
}