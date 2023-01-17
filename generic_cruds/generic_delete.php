<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    // Verification that used method is correct
    if($_SERVER['REQUEST_METHOD'] != 'DELETE'){
        throw new Exception("Invalid request method. Only POST is allowed", 405);
    }
        // Including files for config and data access
        include_once '../../Database.php';
        include_once '../models/CRUD.php';
    
        // DDB instanciation
        $database = new Database();
        $db = $database->getConnection();
    
        // crudObjects instanciation
        $crudObject = new CRUD($db);
    
        // Get uuid from url
        $uuid = $_GET['uuid'];
    
        if(!empty($uuid)){
        
            $crudObject->uuid = $uuid;
        
            if($crudObject->delete($sql)){
            
                http_response_code(200);
            
                echo json_encode(["message" => "The data have been deleted"]);
            
            }else{
                http_response_code(503);
                echo json_encode(["message" => "The data haven't been deleted"]);
            }
        }else{
            // We catch the error
            http_response_code(403);
            echo json_encode(["message" => "Arguments doesn't match"]);
        }

} catch (Exception $e){
    http_response_code($e->getCode());
    echo json_encode(["Message" => $e->getMessage()]);
    error_log($e->getMessage());
}