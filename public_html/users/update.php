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
    include_once '../models/Users.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();

    // Users instanciation
    $user = new Users($db);

    // Get back sended informations
    $datas = json_decode(file_get_contents("php://input"));

    if(!empty($datas->uuid) && !empty($datas->name) && !empty($datas->firstname) && !empty($datas->email) && !empty($datas->phone) && !empty($datas->number_of_followers)
     && !empty($datas->number_of_moons) && !empty($datas->number_of_friends) && !empty($datas->url_profile_picture) && !empty($datas->description) && !empty($datas->sign_in)
      && !empty($datas->last_connection)){

        //here we receive datas, we hydrate our object
        $user->uuid = $datas->uuid;
        $user->name = $datas->name;
        $user->firstname = $datas->firstname;
        $user->email = $datas->email;
        $user->phone = $datas->phone;
        $user->description = $datas->description;
        $user->number_of_followers = $datas->number_of_followers;
        $user->number_of_moons = $datas->number_of_moons;
        $user->number_of_friends = $datas->number_of_friends;
        $user->url_profile_picture = $datas->url_profile_picture;
        $user->sign_in = $datas->sign_in;
        $user->last_connection = $datas->last_connection;

        if($user->update()){
            // Here it worked => code 200
            http_response_code(200);
            echo json_encode(["message" => "The change have been done"]);
        }else{
            // Here it didn't worked => code 503
            http_response_code(503);
            echo json_encode(["message" => "The change haven't been done"]);
        }

      }else{
        // We catch the error
        http_response_code(403);
        echo json_encode(["message" => "Number of arguments doesn't match"]);
    }
}else{
    // We catch the error
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);
}