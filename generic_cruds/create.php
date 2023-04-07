<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    // Vérification que la méthode HTTP utilisée est correcte
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new InvalidArgumentException("Invalid request method. Only POST is allowed", 405);
    }

    // Récupération des données postées dans la requête HTTP
    $input = json_decode(file_get_contents("php://input"), true);

    // Vérification que les données postées sont bien au format JSON
    if (!$input) {
        throw new InvalidArgumentException("Invalid input data. Must be valid JSON", 400);
    }

    // Vérification que le nom de la table est bien présent dans les données postées
    if (!isset($input['table_index'])) {
        throw new InvalidArgumentException("Table index not provided", 400);
    }

    // Récupération de l'index du tableau contenant les noms de colonnes pour la table correspondante
    $table_index = $input['table_index'];
    unset($input['table_index']);

    // Récupération des noms de colonnes pour la table correspondante à partir du tableau correspondant
    $tabTables = [
        $tabMessages,
        $tabRecordsRead,
        $tabRecords,
        $tabUsers,
        $tabConversations,
        $tabFriends
    ];
    $table_columns = $tabTables[$table_index];

    // Construction de la requête SQL en utilisant les noms de colonnes pour la table correspondante et les données postées
    $table_name = array_keys($table_columns)[0];
    $sql = "INSERT INTO $table_name (";
    $sql .= implode(', ', array_values($table_columns));
    $sql .= ") VALUES (";
    $sql .= "'" . implode("', '", array_values($input)) . "'";
    $sql .= ")";

    // Inclusion des fichiers pour la configuration et l'accès aux données
    require_once '../../Database.php';
    require_once '../models/CRUD.php';

    // Instanciation de la base de données et des enregistrements
    $database = new Database();
    $db = $database->getConnection();
    $crudObject = new CRUD($db);

    // Appel de la méthode create avec la requête SQL
    if($crudObject->create($sql)) {
// Réponse 201 si l'insertion a réussi
        http_response_code(201);
        echo json_encode(["message" => "The record was created successfully"]);
    } else {
// Réponse 503 si l'insertion a échoué
        http_response_code(503);
        echo json_encode(["message" => "The record could not be created"]);
    }
} catch (Exception $e) {
// Réponse d'erreur pour les exceptions générées
    http_response_code($e->getCode());
    echo json_encode(["message" => $e->getMessage()]);
    error_log($e->getMessage());
}
