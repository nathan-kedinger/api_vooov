<?php
    include_once '../tabs/tabs.php';

    // Expected table
    $table = "users"; // Change with the good BDD table name

    $arguments = $tabUsers;// Replace with the good tab

    $sql = "SELECT ". implode(', ', array_map(function($argument) 
    { return $argument; }, $arguments)) . " FROM " . $table ."
    WHERE email = ? LIMIT 0,1";

    include_once '../special_cruds/generic_readOneUserByMail.php';