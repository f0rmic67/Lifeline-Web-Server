<?php
    require('encrypt.php');
    require_once("db_connect.php");

    $status = session_status();
	if($status == PHP_SESSION_NONE){
		session_start();
	}

    $fname = filter_input(INPUT_POST, "fname");
    $lname = filter_input(INPUT_POST, "lname");
    $dob = filter_input(INPUT_POST, "dob");

    $heart = encryptData(filter_input(INPUT_POST, "heartProblems"), $key);
    $heartmed = encryptData(filter_input(INPUT_POST, "heartProblem"), $key);
    $pacemaker = encryptData(filter_input(INPUT_POST, "pacemakers"), $key);
    $pacemakermed = encryptData(filter_input(INPUT_POST, "pacemaker"), $key);
    $diabetes = encryptData(filter_input(INPUT_POST, "diabetes"), $key);
    $diabetesmed = encryptData(filter_input(INPUT_POST, "diabete"), $key);
    $bp = encryptData(filter_input(INPUT_POST, "highBloodPressure"), $key);
    $bpmed = encryptData(filter_input(INPUT_POST, "highBP"), $key);
    $stroke = encryptData(filter_input(INPUT_POST, "Strokes"), $key);
    $strokemed = encryptData(filter_input(INPUT_POST, "stroke"), $key);
    $asthma = encryptData(filter_input(INPUT_POST, "Asthma"), $key);
    $asthmamed = encryptData(filter_input(INPUT_POST, "asthma"), $key);
    $seizure = encryptData(filter_input(INPUT_POST, "Seizures"), $key);
    $seizuremed = encryptData(filter_input(INPUT_POST, "seizure"), $key);
    $cancer = encryptData(filter_input(INPUT_POST, "Cancer"), $key);
    $cancermed = encryptData(filter_input(INPUT_POST, "cancer"), $key);
    $allergy = encryptData(filter_input(INPUT_POST, "Allergies"), $key);
    $allergymed = encryptData(filter_input(INPUT_POST, "allergy"), $key);
    $other = encryptData(filter_input(INPUT_POST, "Other"), $key);
    $othermed = encryptData(filter_input(INPUT_POST, "other"), $key);

    $efname = filter_input(INPUT_POST, "efname");
    $elname = filter_input(INPUT_POST, "elname");
    $relation = filter_input(INPUT_POST, "relation");
    $phone = filter_input(INPUT_POST, "phone");

    $query = "UPDATE student_medical_info SET dob = :dob, heart_problems = :heart,
        heart_problems_medications = :heartmed, pacemaker = :pace, pacemaker_medications = :pacemed, 
        diabetes = :diabetes, diabetes_medications = :diabetesmed, high_bp = :highbp, high_bp_medications = :highbpmed, 
        stroke = :stroke, stroke_medications = :strokemed, asthma_copd = :asthma, asthma_copd_medications = :asthmamed, 
        seizures = :seizure, seizures_medications = :seizuremed, cancer = :cancer, cancer_medications = :cancermed, 
        allergies = :allergy, allergies_medications = :allergymed, other = :other, other_medications = :othermed 
        WHERE id=:id";
    $insert = $db->prepare($query);
    $insert->bindParam(":id", $_SESSION['id']);
    $insert->bindParam(":dob", $dob);
    $insert->bindParam(":heart", $heart);
    $insert->bindParam(":heartmed", $heartmed);
    $insert->bindParam(":pace", $pacemaker);
    $insert->bindParam(":pacemed", $pacemakermed);
    $insert->bindParam(":diabetes", $diabetes);
    $insert->bindParam(":diabetesmed", $diabetesmed);
    $insert->bindParam(":highbp", $bp);
    $insert->bindParam(":highbpmed", $bpmed);
    $insert->bindParam(":stroke", $stroke);
    $insert->bindParam(":strokemed", $strokemed);
    $insert->bindParam(":asthma", $asthma);
    $insert->bindParam(":asthmamed", $asthmamed);
    $insert->bindParam(":seizure", $seizure);
    $insert->bindParam(":seizuremed", $seizuremed);
    $insert->bindParam(":cancer", $cancer);
    $insert->bindParam(":cancermed", $cancermed);
    $insert->bindParam(":allergy", $allergy);
    $insert->bindParam(":allergymed", $allergymed);
    $insert->bindParam(":other", $other);
    $insert->bindParam(":othermed", $othermed);

    if($insert->execute()){
        $error_msg = ''; 
    }
    else{
        $error_msg = "Update failed.";
    }

    $query = "UPDATE emergency_contacts SET e_first_name = :efname, e_last_name = :elname, relation = :relation, phone_number = :phone WHERE id = :id";
    $insert = $db->prepare($query);
    $insert->bindParam(":efname", $efname);
    $insert->bindParam(":elname", $elname);
    $insert->bindParam(":relation", $relation);
    $insert->bindParam(":phone", $phone);
    $insert->bindParam(":id", $_SESSION['id']);
    
    if($insert->execute()){
        $error_msg = '';
    }
    else{
        $error_msg = "Update failed.";
    }

    $query = "UPDATE user SET first_name = :fname, last_name = :lname WHERE id = :id";
    $insert = $db->prepare($query);
    $insert->bindParam(":fname", $fname);
    $insert->bindParam(":lname", $lname);
    $insert->bindParam(":id", $_SESSION['id']);
    
    if($insert->execute()){
        $error_msg = '';
    }
    else{
        $error_msg = "Update failed.";
    }

    header("Location:HomePage.php");
    exit();
?>