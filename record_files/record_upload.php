<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    /**
    * Script to handle a POST request
    *
    * @throws InvalidArgumentException if the request method is not POST or if the input file is not valid JSON
    */
    // Verification that used method is correct
    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] != 'POST'){
        throw new InvalidArgumentException("Invalid request method. Only POST is allowed", 405);
    }
        $target_dir = "records/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

        // Check if the file has been uploaded
        if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error'])) {
            throw new InvalidArgumentException("Invalid input data. Must be valid file", 400);
        }

        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new InvalidArgumentException("No file sent", 400);
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new InvalidArgumentException("Exceeded filesize limit", 400);
            default:
                throw new InvalidArgumentException("Unknown errors", 400);
        }

        /*// Check file mime type
        $file_mime = mime_content_type($_FILES["file"]["tmp_name"]);
        if ($file_mime != 'audio/mp4' && $file_mime != 'audio/mpeg' && $file_mime != 'audio/ogg' && 
        $file_mime != 'audio/wav' && $file_mime != 'audio/x-flac' && $file_mime != 'audio/3gpp'){
        throw new InvalidArgumentException("Invalid input file. Must be one of .mp4, .mp3, .ogg, .wav, .3gp, or .flac", 408);
        }*/

        // Check file size
        $file_size = $_FILES["file"]["size"];
        if($file_size > 3000000){
            throw new InvalidArgumentException("File is to big. Max size is 3Mo", 400);
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo json_encode(["message" => "File uploaded successfully."]);
        } else {
            echo json_encode(["message" => "There was an error uploading the file."]);
        }

        
} catch (Exception $e){
    http_response_code($e->getCode());
    echo json_encode(["Message" => $e->getMessage()]);
    error_log($e->getMessage(),0,'../error_logs.log');
}
