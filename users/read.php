<?php
    include_once '../tabs/tabs.php';

    // Expected table
    $table = "users"; // Change with the good BDD table name

    // Datas
    $arguments = $tabUsers;// Replace with the good tab

    // SQL request
    $sql = "SELECT * FROM " . $table; // It is possible to add a join after that
    
    include_once '../generic_cruds/generic_read.php';
