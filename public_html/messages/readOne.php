<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Verification that used method is correct
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // Including files for config and data access
    include_once '../../Database.php';
    include_once '../models/CRUD.php';
    include_once '../tabs/tabs.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();
    $table = "messages"; // Change with the good BDD table name

    $arguments = $tabMessages;

    $sql = "SELECT ". implode(', ', array_map(function($argument) 
    { return $argument; }, $arguments)) . " FROM " . $table ."
    WHERE uuid = ? LIMIT 0,1";

    // Messages instanciation
    $message = new CRUD($db);

    // Get datas
    $datas = json_decode(file_get_contents("php://input"));

    // Verifying that we have at least one message
    if(!empty($datas->uuid)){
        $message->uuid = $datas->uuid;

        $message->readOne($arguments, $sql);
        
            $message = [
                "uuid" => $message->uuid,
                "sender" => $message->sender ,
                "receiver" => $message->receiver ,
                "body" => $message->body ,
                "seen" => $message->seen ,
                "send_at" => $message->send_at ,
            ];

        http_response_code(200);

        echo json_encode($message);

    }else{
        http_response_code(404);
        echo json_encode(array("message" => "This message doesn't exists."));
    }
    
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);

}