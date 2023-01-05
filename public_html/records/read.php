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

    // Records instanciation
    $records = new Records($db);

    // Get datas
    $stmt = $records->read();

    // Verifying that we have at least one user
    if($stmt->rowCount() > 0){
        //initialisation of an associative tab

        $tabrecords = [];
        $tabrecords['records'] = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $record = [
                "uuid" => $uuid,
                "artist_uuid" => $artist_uuid ,
                "title" => $title ,
                "length" => $length ,
                "number_of_plays" => $number_of_plays ,
                "number_of_moons" => $number_of_moons ,
                "voice_style" => $voice_style ,
                "kind" => $kind ,
                "description" => $description ,
                "created_at" => $created_at ,
                "updated_at" => $updated_at,
            ];

            $tabrecords['records'][] = $record;
        }

        http_response_code(200);

        echo json_encode($tabrecords);

    }
    
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);

}