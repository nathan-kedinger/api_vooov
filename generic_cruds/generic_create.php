<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    // Verification that used method is correct
    if($_SERVER['REQUEST_METHOD'] != 'POST'){ // Change with good method
        throw new Exception("Invalid request method. Only POST is allowed", 405);
    }
        // Including files for config and data access
        include_once '../../Database.php';
        include_once '../models/CRUD.php';

        // DDB instanciation
        $database = new Database();
        $db = $database->getConnection();

        // Records instanciation
        $crudObject = new CRUD($db);

        // Get back sended informations
        $datas = json_decode(file_get_contents("php://input"));

        foreach($arguments as $argument){
            if(isset($datas->$argument)){
                //here we receive datas, we hydrate our object
                $crudObject->$argument = $datas->$argument;
            }else{
                // We catch the error
                http_response_code(400);
                echo json_encode(["message" => "Arguments doesn't match"]);
            }
        }
        if($crudObject->create($arguments, $sql)){
            // Here it worked => code 201
            http_response_code(201);
            echo json_encode(["message" => "The add have been done"]);
        }else{
            // Here it didn't worked => code 503
            http_response_code(503);
            echo json_encode(["message" => "The add haven't been done"]);
        }
        
} catch (Exception $e){
    http_response_code($e->getCode());
    echo json_encode(["Message" => $e->getMessage()]);
    error_log($e->getMessage());
}
