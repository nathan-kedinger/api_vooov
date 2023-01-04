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
    include_once '../models/Messages.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();

    // Message instanciation
    $message = new Messages($db);

    // Get datas
    $stmt = $message->read();

    // Verifying that we have at least one user
    if($stmt->rowCount() > 0){
        //initialisation of an associative tab

        $tabmessage = [];
        $tabmessage['message'] = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $message = [
                "uuid" => $uuid,
                "sender" => $sender ,
                "receiver" => $receiver ,
                "body" => $body ,
                "seen" => $seen ,
                "send_at" => $send_at ,
            ];

            $tabmessage['message'][] = $message;
        }

        http_response_code(200);

        echo json_encode($tabmessage);

    }
    
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);

}