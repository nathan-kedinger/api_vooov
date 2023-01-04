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
    include_once '../models/Records.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();

    // records instanciation
    $record = new Records($db);

    // Get datas
    $datas = json_decode(file_get_contents("php://input"));


    // Verifying that we have at least one record
    if(!empty($datas->uuid)){
        $record->uuid = $datas->uuid;

        $record->readOne();
        
            $record = [
                "uuid" => $record->uuid,
                "artist_uuid" => $record->artist_uuid ,
                "title" => $record->title ,
                "number_of_play" => $record->number_of_play ,
                "number_of_moons" => $record->number_of_moons ,
                "voice_style" => $record->voice_style ,
                "kind" => $record->kind ,
                "description" => $record->description ,
                "created_at" => $record->created_at,
                "updated_at" => $record->updated_at,
            ];

        http_response_code(200);

        echo json_encode($record);

    }else{
        http_response_code(404);
        echo json_encode(array("message" => "This record doesn't exists."));
    }
    
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);

}