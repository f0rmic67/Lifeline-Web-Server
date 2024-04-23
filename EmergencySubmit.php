<?php
    $status = session_status();
	if($status == PHP_SESSION_NONE){
		session_start();
	}

    //encryption setup
    $hash = hash('sha256', $_SESSION['id']);
    //hash student ID  and use substring as cipher key
    $key = substr($hash, 9, 9);
    //encryption method
    $method = "aes-128-cbc";
    //initialization vector, set to last 16 bytes of hashed user ID
    $iv = substr($hash, -16, 16);

    require_once("db_connect.php");

    $fname = filter_input(INPUT_POST, "fname");
    $lname = filter_input(INPUT_POST, "lname");
    $dob = filter_input(INPUT_POST, "dob");

    $heart = openssl_encrypt(filter_input(INPUT_POST, "heartProblems"), $method, $key, 0, $iv);
    $heartmed = openssl_encrypt(filter_input(INPUT_POST, "heartProblem"), $method, $key, 0, $iv);
    $pacemaker = openssl_encrypt(filter_input(INPUT_POST, "pacemakers"), $method, $key, 0, $iv);
    $pacemakermed = openssl_encrypt(filter_input(INPUT_POST, "pacemaker"), $method, $key, 0, $iv);
    $diabetes = openssl_encrypt(filter_input(INPUT_POST, "diabetes"), $method, $key, 0, $iv);
    $diabetesmed = openssl_encrypt(filter_input(INPUT_POST, "diabete"), $method, $key, 0, $iv);
    $bp = openssl_encrypt(filter_input(INPUT_POST, "highBloodPressure"), $method, $key, 0, $iv);
    $bpmed = openssl_encrypt(filter_input(INPUT_POST, "highBP"), $method, $key, 0, $iv);
    $stroke = openssl_encrypt(filter_input(INPUT_POST, "Strokes"), $method, $key, 0, $iv);
    $strokemed = openssl_encrypt(filter_input(INPUT_POST, "stroke"), $method, $key, 0, $iv);
    $asthma = openssl_encrypt(filter_input(INPUT_POST, "Asthma"), $method, $key, 0, $iv);
    $asthmamed = openssl_encrypt(filter_input(INPUT_POST, "asthma"), $method, $key, 0, $iv);
    $seizure = openssl_encrypt(filter_input(INPUT_POST, "Seizures"), $method, $key, 0, $iv);
    $seizuremed = openssl_encrypt(filter_input(INPUT_POST, "seizure"), $method, $key, 0, $iv);
    $cancer = openssl_encrypt(filter_input(INPUT_POST, "Cancer"), $method, $key, 0, $iv);
    $cancermed = openssl_encrypt(filter_input(INPUT_POST, "cancer"), $method, $key, 0, $iv);
    $allergy = openssl_encrypt(filter_input(INPUT_POST, "Allergies"), $method, $key, 0, $iv);
    $allergymed = openssl_encrypt(filter_input(INPUT_POST, "allergy"), $method, $key, 0, $iv);
    $other = openssl_encrypt(filter_input(INPUT_POST, "Other"), $method, $key, 0, $iv);
    $othermed = openssl_encrypt(filter_input(INPUT_POST, "other"), $method, $key, 0, $iv);

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