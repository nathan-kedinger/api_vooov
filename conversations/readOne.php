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
    $table = "conversations"; // Change with the good BDD table name

    $arguments = $tabConversations;// Replace with the good tab

    $sql = "SELECT ". implode(', ', array_map(function($argument) 
    { return $argument; }, $arguments)) . " FROM " . $table ."
    WHERE uuid = ? LIMIT 0,1";

    // conversations instanciation
    $conversation = new CRUD($db);

    // Get datas
    $datas = json_decode(file_get_contents("php://input"));

    // Verifying that we have at least one conversation
    if(!empty($datas->uuid)){
        $conversation->uuid = $datas->uuid;

        $conversation->readOne($arguments, $sql);
        
            $conversation = [
                "uuid" => $conversation->uuid,
                "sender" => $conversation->sender,
                "receiver" => $conversation->receiver,
                "title" => $conversation->title,
                "created_at" => $conversation->created_at,
                "updated_at" => $conversation->updated_at,
            ];

        http_response_code(200);

        echo json_encode($conversation);

    }else{
        http_response_code(404);
        echo json_encode(array("message" => "This conversation doesn't exists."));
    }
    
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);

}