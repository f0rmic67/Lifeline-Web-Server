<?php
    require_once("db_connect.php");

    $ems_id = filter_input(INPUT_POST, "ems_id", FILTER_VALIDATE_INT);
    $fname = filter_input(INPUT_POST, "fname");
    $lname = filter_input(INPUT_POST, "lname");

    $query = "SELECT * FROM ems_employees WHERE ems_id = :ems_id";
    $check = $db->prepare($query);
    $check->bindParam(":ems_id", $ems_id);
    $check->execute();
    $existing = $check->fetchAll();
    $check->closeCursor();

    if(empty($existing)){
        $query = "INSERT INTO ems_employees(ems_id, fname, lname) VALUES (:ems_id, :fname, :lname)";
        $insert = $db->prepare($query);
        $insert->bindParam(":ems_id", $ems_id);
        $insert->bindParam(":fname", $fname);
        $insert->bindParam(":lname", $lname);
        $insert->execute();

        header("Location:uploadSheet.php");
        exit();
    }
    else{
        $error_msg = "Employee already registered.";
    }
?>