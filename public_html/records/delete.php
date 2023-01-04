<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// Verification that used method is correct
if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    // Including files for config and data access
    include_once '../../Database.php';
    include_once '../models/Records.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();

    // records instanciation
    $record = new Records($db);

    // Get back sended informations
    $datas = json_decode(file_get_contents("php://input"));

    if(!empty($datas->uuid)){

        $record->uuid = $datas->uuid;

        if($record->delete()){

            http_response_code(200);

            echo json_encode(["message" => "The record have been deleted"]);

        }else{
            http_response_code(503);
            echo json_encode(["message" => "The record haven't been deleted"]);
        }
    }
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);
}