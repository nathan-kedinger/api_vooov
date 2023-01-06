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
    include_once '../models/CRUD.php';//change with the

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();
    $table = "friends";

    // friend instanciation
    $friend = new CRUD($db);

    // SQL request
    $sql = "SELECT * FROM " . $table; // It is possible to add a join after that

    // Get datas
    $stmt = $friend->read($sql);

    // Verifying that we have at least one row in database
    if($stmt->rowCount() > 0){
        //initialisation of an associative tab
        $tabFriend = [];
        $tabFriend['friend'] = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $friend = [
                "uuid" => $uuid,
                "sender" => $sender ,
                "receiver" => $receiver ,
                "body" => $body ,
                "seen" => $seen ,
                "send_at" => $send_at ,
            ];

            $tabFriend['friend'][] = $friend;
        }

        http_response_code(200);

        echo json_encode($tabfriend);

    }else{
        http_response_code(400);
        echo json_encode(["message" => "There is no row in that table"]);
    }
    
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);
}