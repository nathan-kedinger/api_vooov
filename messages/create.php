<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// Verification that used method is correct
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Including files for config and data access
    include_once '../Database.php';
    include_once '../models/Message.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();

    // Records instanciation
    $message = new Messages($db);

    // Get back sended informations
    $datas = json_decode(file_get_contents("php://input"));

    if(!empty($datas->uuid) && !empty($datas->sender) && !empty($datas->receiver)
     && !empty($datas->body) && !empty($datas->seen) && !empty($datas->send_at)){

        //here we receive datas, we hydrate our object
        $message->uuid = $datas->uuid;
        $message->sender = $datas->sender;
        $message->receiver = $datas->receiver;
        $message->body = $datas->body;
        $message->seen = $datas->seen;
        $message->send_at = $datas->send_at;

        if($message->create()){
            // Here it worked => code 201
            http_response_code(201);
            echo json_encode(["message" => "The add have been done"]);
        }else{
            // Here it didn't worked => code 503
            http_response_code(503);
            echo json_encode(["message" => "The add haven't been done"]);
        }

      }
}else{
    // We catch the mistake
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);
}