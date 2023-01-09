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
    include_once '../models/CRUD.php';//change with the
    include_once '../tabs/tabs.php';

    // DDB instanciation
    $database = new Database();
    $db = $database->getConnection();

    // crudObject instanciation
    $crudObject = new CRUD($db);

    // Expected table
    $table = "friends";

    // Datas
    $arguments = $tabFriends;// Replace with the good tab

    // SQL request
    $sql = "SELECT * FROM " . $table; // It is possible to add a join after that

    // Get datas
    $stmt = $crudObject->read($sql);

    // Verifying that we have at least one row in database
    if($stmt->rowCount() > 0){
        //initialisation of an associative tab
        $tabFriend = [];
        $tabFriend[$table] = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
        
                $friend = [];
                    foreach($arguments as $argument){
                        $friend[$argument] = $row[$argument];
                    }
        
            $tabFriend[$table][] = $friend;
        }

        http_response_code(200);

        echo json_encode($tabFriend);

    }else{
        http_response_code(400);
        echo json_encode(["message" => "There is no row in that table"]);
    }
    
}else{
    http_response_code(405);
    echo json_encode(["message" => "This method isn't authorised"]);
}