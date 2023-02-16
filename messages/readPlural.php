<?php
include_once '../tabs/tabs.php';

    // Expected table
    $table = "messages";

    $theOneToGet = "conversation_uuid";

    // Datas
    $arguments = $tabMessages;// Replace with the good tab

    // SQL request
    $sql = "SELECT " . implode(', ', array_map(function($argument) 
    {return $argument;}, $arguments)) . " FROM " . $table . " WHERE " 
    . $theOneToGet . " = ?"; // It is possible to add a join after that

include_once '../generic_cruds/generic_readPlural.php';