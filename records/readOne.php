<?php
    include_once '../tabs/tabs.php';

    // Expected table
    $table = "audio_records"; // Change with the good BDD table name

    $theOneToGet = "uuid"; // Change with the good column

    $arguments = $tabRecords;// Replace with the good tab

    $sql = "SELECT ". implode(', ', array_map(function($argument) 
    { return $argument; }, $arguments)) . " FROM " . $table ."
    WHERE ". $theOneToGet ." = ? LIMIT 0,1";

    include_once '../generic_cruds/generic_readOne.php';
