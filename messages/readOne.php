<?php
    include_once '../tabs/tabs.php';

    // Expected table
    $table = "messages"; // Change with the good BDD table name

    $theOneToGet = "conversation_uuid"; // Change with the good column

    $arguments = $tabMessages;// Replace with the good tab

    $sql = "SELECT ". implode(', ', array_map(function($argument) 
    { return $argument; }, $arguments)) . " FROM " . $table ."
    WHERE ". $theOneToGet ." = ? ";

    include_once '../generic_cruds/generic_readOne.php';