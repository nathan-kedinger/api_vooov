<?php
    // Expected table
    $table = "friends"; // Change with the good BDD table name

    $sql = "DELETE FROM " . $table ." WHERE uuid = ?";

    include_once '../generic_cruds/generic_delete.php';
  