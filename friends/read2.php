<?php

    // Expected table
    $table = "friends";

    // Datas
    $arguments = $tabFriends;// Replace with the good tab

    // SQL request
    $sql = "SELECT * FROM " . $table; // It is possible to add a join after that

    include_once '../generic_cruds/generic_read.php';