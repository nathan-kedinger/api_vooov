<?php
    include_once '../tabs/tabs.php';

    $table = "friends"; // Change with the good BDD table name

    // Datas
    $arguments = $tabFriends;// Replace with the good tab

    // SQL request
    $sql = "INSERT INTO " . $table . " SET ". implode(', ', array_map(function($argument) 
    { return $argument . '=:' . $argument; }, $arguments)); 

    include_once '../generic_cruds/generic_create.php';
