<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    /**
    * Script to handle a GET request for one data
    *
    * @throws InvalidArgumentException if the request method is not GET
    */
    // Verification that used method is correct
    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        throw new Exception("Invalid request method. Only GET is allowed", 405);
    }   
        // Including files for config and data access
        include_once '../../Database.php';
        include_once '../models/CRUD.php';

        // DDB instanciation
        $database = new Database();
        $db = $database->getConnection();

        // crudObject$crudObjects instanciation
        $crudObject = new CRUD($db);

        // Get uuid from url
        $uuid = $_GET['uuid'];

        // Verifying that we have at least one crudObject
        if (!empty($uuid)) {
            
        $crudObject->uuid = $uuid;

            $crudObject->readOne($arguments, $sql);

            $oneShowedData = [];
            foreach ($arguments as $argument){
                $oneShowedData[$argument] = $crudObject->$argument;
            }

            http_response_code(200);

            echo json_encode($oneShowedData);

        }else{
            http_response_code(404);
            echo json_encode(array("message" => "This ref doesn't exists."));
        }
        
} catch (Exception $e){
    http_response_code($e->getCode());
    echo json_encode(["Message" => $e->getMessage()]);
    error_log($e->getMessage());
}