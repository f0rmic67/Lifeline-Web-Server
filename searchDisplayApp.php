<?php
    require_once("db_connect.php");
    
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

    $query = "SELECT id FROM user WHERE id = :id";
    $select = $db->prepare($query);
    $select->bindParam(":id", $id);

    if($select->execute()){
        $account = $select->fetch();
        $select->closeCursor();
                
        if($id == $account['id']){
            $query = "SELECT first_name, last_name FROM user WHERE id = :id";
            $select = $db->prepare($query);
            $select->bindParam(":id", $id);
            $select->execute();
            $displayUser = $select->fetch();
            $select->closeCursor();

            echo json_encode($displayUser);

            $query = "SELECT * FROM emergency_contacts WHERE student_id = :id";
            $select = $db->prepare($query);
            $select->bindParam(":id", $id);
            $select->execute();
            $displayContact = $select->fetch();
            $select->closeCursor();

            echo json_encode($displayContact);

            //only retreive medical info if account type is EMS or EMS admin
            if($_SESSION['acc_type'] == 2 || $_SESSION['acc_type'] == 3){
                $query = "SELECT * FROM student_medical_info WHERE student_id = :id";
                $select = $db->prepare($query);
                $select->bindParam(":id", $id);
                $select->execute();
                $displayMed = $select->fetch();
                $select->closeCursor();

                echo json_encode($displayMed);
            }

            //save search to recent_lookups table
            $query = "INSERT INTO recent_lookups(search_time, student_id) VALUES (:search_time, :id)";
            $insert = $db->prepare($query);
            //get timestamp for search
            $search_time = date('Y-m-d H:i:s');
            $insert->bindParam(":search_time", $search_time);
            $insert->bindParam(":id", $id);
            $insert->execute();
            $insert->closeCursor();
        }
        else{
            $error_msg = "No user found.";
        }
    }
    else{
        $error_msg = "Select failed";
    }
?>

