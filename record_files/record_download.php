<?php

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: audio/mpeg");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    // Vérification de la méthode HTTP utilisée
    if(!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] != 'GET'){
        throw new Exception("Invalid request method. Only GET is allowed", 405);
    }   

    // Validation des paramètres de la requête
    if (!isset($_GET['file']) || empty($_GET['file'])) {
        throw new Exception("Invalid file name. Please provide a file name", 400);
    }

    // Récupération du fichier demandé
    $target_dir = "records/";
    $file_name = $_GET['file'];
    $file_path = $target_dir . $file_name;

    // Vérification de l'existence du fichier
    if (!file_exists($file_path)) {
        throw new Exception("File not found", 404);
    }

    // Vérification que le fichier est dans le dossier autorisé
    $real_path = realpath($file_path);
    $real_target_dir = realpath($target_dir);
    if (strpos($real_path, $real_target_dir) !== 0) {
        throw new Exception("Access denied. File is not within allowed directory", 403);
    }

    // Envoi du fichier audio demandé
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
        
} catch (Exception $e){
    http_response_code($e->getCode());
    echo json_encode(["Message" => $e->getMessage()]);
    error_log($e->getMessage(),0,'../error_logs.txt');
}