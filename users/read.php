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
    include_once '../Database.php';
    include_once '../models/Users.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();

    // Users instanciation
    $user = new Users($db);

    // Get datas
    $stmt = $user->read();

    // Verifying that we have at least one user
    if($stmt->rowCount() > 0){
        //initialisation of an associative tab

        $tabUsers = [];
        $tabUsers['users'] = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $user = [
                "uuid" => $uuid,
                "name" => $name ,
                "firstname" => $firstname ,
                "email" => $email ,
                "phone" => $phone ,
                "description" => $description ,
                "number_of_followers" => $number_of_followers ,
                "number_of_moons" => $number_of_moons ,
                "number_of_friends" => $number_of_friends ,
                "url_profile_picture" => $url_profile_picture,
                "sign_in" => $sign_in,
                "last_connection" => $last_connection,
            ];

            $tabUsers['users'][] = $user;
        }

        http_response_code(200);

        echo json_encode($tabUsers);

    }
    
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);

}