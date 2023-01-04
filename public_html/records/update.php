<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// Verification that used method is correct
if($_SERVER['REQUEST_METHOD'] == 'PUT'){
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

    if(!empty($datas->uuid) && !empty($datas->artist_uuid) && !empty($datas->title) && !empty($datas->number_of_play)
     && !empty($datas->number_of_moons) && !empty($datas->voice_style) && !empty($datas->kind) 
     && !empty($datas->description) && !empty($datas->created_at) && !empty($datas->updated_at)){

        //here we receive datas, we hydrate our object
        $record->uuid = $datas->uuid;
        $record->artist_uuid = $datas->artist_uuid;
        $record->title = $datas->title;
        $record->number_of_play = $datas->number_of_play;
        $record->number_of_moons = $datas->number_of_moons;
        $record->voice_style = $datas->voice_style;
        $record->kind = $datas->kind;
        $record->description = $datas->description;
        $record->created_at = $datas->created_at;
        $record->updated_at = $datas->updated_at;

        if($record->update()){
            // Here it worked => code 200
            http_response_code(200);
            echo json_encode(["massage" => "The add have been done"]);
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