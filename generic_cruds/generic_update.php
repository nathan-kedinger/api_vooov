<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


try{
    /**
    * Script to handle a PUT request
    *
    * @throws InvalidArgumentException if the request method is not PUT or if the input data is not valid JSON
    */
    // Verification that used method is correct
    if($_SERVER['REQUEST_METHOD'] != 'PUT'){ // Change with good method
        throw new Exception("Invalid request method. Only PUT is allowed", 405);
    }
        // Including files for config and data access
        include_once '../../Database.php';
        include_once '../models/CRUD.php';

        // DDB instanciation
        $database = new Database();
        $db = $database->getConnection();

        // Records instanciation
        $crudObject = new CRUD($db);

    // Get input data
    $input = file_get_contents("php://input");
    if (!$input = json_decode($input)) {
        throw new InvalidArgumentException("Invalid input data. Must be valid JSON", 405);
    }
        $datas = $input;
        foreach($arguments as $argument){
            if(isset($datas->$argument)){
                //here we receive datas, we hydrate our object
                $crudObject->$argument = $datas->$argument;
            }else{
                // We catch the mistake
                http_response_code(400);
                echo json_encode(["message" => "Arguments doesn't match"]);
            }
        }
        if($crudObject->update($arguments, $sql)){
            // Here it worked => code 201
            http_response_code(201);
            echo json_encode(["message" => "The change have been done"]);
        }else{
            // Here it didn't worked => code 503
            http_response_code(503);
            echo json_encode(["message" => "The change haven't been done"]);
        }
        
} catch (Exception $e){
    http_response_code($e->getCode());
    echo json_encode(["Message" => $e->getMessage()]);
    error_log($e->getMessage());
}