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
    $table = "audio_records"; // Change with the good BDD table name

    $arguments = $tabRecords;// Replace with the good tab

    $sql = "SELECT ". implode(', ', array_map(function($argument) 
    { return $argument; }, $arguments)) . " FROM " . $table ."
    WHERE uuid = ? LIMIT 0,1";

    // Messages instanciation
    $record = new CRUD($db);

    // Get datas
    $datas = json_decode(file_get_contents("php://input"));


    // Verifying that we have at least one record
    if(!empty($datas->uuid)){
        $record->uuid = $datas->uuid;

        $record->readOne($arguments, $sql);
        
            $record = [
                "uuid" => $record->uuid,
                "artist_uuid" => $record->artist_uuid ,
                "title" => $record->title ,
                "length" => $record->length ,
                "number_of_plays" => $record->number_of_plays ,
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
        echo json_encode(array("message" => "We couldn't get the record"));
    }
    
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);

}