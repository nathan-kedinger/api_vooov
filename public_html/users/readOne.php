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
    include_once '../models/Users.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();

    // Users instanciation
    $user = new Users($db);

    // Get datas
    $datas = json_decode(file_get_contents("php://input"));


    // Verifying that we have at least one user
    if(!empty($datas->uuid)){
        $user->uuid = $datas->uuid;

        $user->readOne();
        
            $user = [
                "uuid" => $user->uuid,
                "name" => $user->name ,
                "firstname" => $user->firstname ,
                "email" => $user->email ,
                "phone" => $user->phone ,
                "description" => $user->description ,
                "number_of_followers" => $user->number_of_followers ,
                "number_of_moons" => $user->number_of_moons ,
                "number_of_friends" => $user->number_of_friends ,
                "url_profile_picture" => $user->url_profile_picture,
                "sign_in" => $user->sign_in,
                "last_connection" => $user->last_connection,
            ];

        http_response_code(200);

        echo json_encode($user);

    }else{
        http_response_code(404);
        echo json_encode(array("message" => "This user doesn't exists."));
    }
    
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);

}