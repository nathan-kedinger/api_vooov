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
    include_once '../models/CRUD.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();
    $table = "friends"; // Change with the good BDD table name

    $sql = "DELETE FROM " . $table ." WHERE uuid = ?";

    // friends instanciation
    $friend = new CRUD($db);

    // Get back sended informations
    $datas = json_decode(file_get_contents("php://input"));

    if(!empty($datas->uuid)){

        $friend->uuid = $datas->uuid;

        if($friend->delete($sql)){

            http_response_code(200);

            echo json_encode(["message" => "The friend have been deleted"]);

        }else{
            http_response_code(503);
            echo json_encode(["message" => "The friend haven't been deleted"]);
        }
    }else{
        // We catch the error
        http_response_code(403);
        echo json_encode(["message" => "Arguments doesn't match"]);
    }
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);
}