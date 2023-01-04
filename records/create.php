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
    include_once '../models/Records.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();

    // Records instanciation
    $user = new Records($db);

    // Get back sended informations
    $datas = json_decode(file_get_contents("php://input"));

    if(!empty($datas->uuid) && !empty($datas->artist_uuid) && !empty($datas->title)
     && !empty($datas->number_of_moons) && !empty($datas->voice_style) && !empty($datas->kind) && !empty($datas->description) && !empty($datas->created_at)
      && !empty($datas->updated_at)){

        //here we receive datas, we hydrate our object
        $user->uuid = $datas->uuid;
        $user->artist_uuid = $datas->artist_uuid;
        $user->title = $datas->title;
        $user->number_of_play = $datas->number_of_play;
        $user->number_of_moons = $datas->number_of_moons;
        $user->voice_style = $datas->voice_style;
        $user->kind = $datas->kind;
        $user->description = $datas->description;
        $user->created_at = $datas->created_at;
        $user->updated_at = $datas->updated_at;

        if($user->create()){
            // Here it worked => code 201
            http_response_code(201);
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