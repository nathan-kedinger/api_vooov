<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    /**
    * Script to handle a GET request for one data
    *
    * @throws InvalidArgumentException if the request method is not GET
    */
    // Verification that used method is correct
    if(!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] != 'GET'){
        throw new Exception("Invalid request method. Only GET is allowed", 405);
    }   

        // Input validation
        if (!isset($_GET['file']) || empty($_GET['file'])) {
            throw new Exception("Invalid file name. Please provide a file name", 400);
        }

        $target_dir = "profile_pictures/";
        $file_name = $_GET['file'];
        $file_path = $target_dir . $file_name;

        // Verifying that file exists
        if (!file_exists($file_path)) {
            throw new Exception("File not found", 404);
        }

        // Checking if file is within allowed directory
        $real_path = realpath($file_path);
        $real_target_dir = realpath($target_dir);
        if (strpos($real_path, $real_target_dir) !== 0) {
            throw new Exception("Access denied. File is not within allowed directory", 403);
        }

        $file_content = file_get_contents($file_path);
        //File send succefully but messages in json_encode block base_64 decoding
        echo json_encode([base64_encode($file_content)]);
        
} catch (Exception $e){
    http_response_code($e->getCode());
    echo json_encode(["Message" => $e->getMessage()]);
    error_log($e->getMessage(),0,'../error_logs.txt');
}