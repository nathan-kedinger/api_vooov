<?php
    include_once '../tabs/tabs.php';

    $table = "conversations"; // Change with the good BDD table name

    $arguments = $tabConversations;// Replace with the good tab

    $sql = "SELECT ". implode(', ', array_map(function($argument) 
    { return $argument; }, $arguments)) . " FROM " . $table ."
    WHERE uuid = ? LIMIT 0,1";

    include_once '../generic_cruds/generic_readOne.php';