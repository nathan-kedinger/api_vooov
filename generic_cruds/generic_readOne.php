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

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();

    // Friends instanciation
    $friend = new CRUD($db);

    // Get datas
    $datas = json_decode(file_get_contents("php://input"));

    // Verifying that we have at least one friend
    if(!empty($datas->uuid)){
        $friend->uuid = $datas->uuid;

        $friend->readOne($arguments, $sql);
        
        foreach ($arguments as $argument){

        }
            $friend [] = [$argument => $argument];


        http_response_code(200);

        echo json_encode($friend);

    }else{
        http_response_code(404);
        echo json_encode(array("message" => "This friend doesn't exists."));
    }
    
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);

}