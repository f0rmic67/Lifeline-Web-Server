<?php
    require_once("db_connect.php");

    $id = filter_input(INPUT_POST, 'id');

    $query = "DELETE FROM ems_employees WHERE ems_id = :ems_id";
    $delete = $db->prepare($query);
    $delete->bindParam(':ems_id', $id);
    $delete->execute();
    $delete->closeCursor();

    header("Location:UploadSheet.php");
    exit();
?>