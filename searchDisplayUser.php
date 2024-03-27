<?php
    $status = session_status();
	if($status == PHP_SESSION_NONE){
		session_start();
	}

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

            $query = "SELECT * FROM emergency_contacts WHERE student_id = :id";
            $select = $db->prepare($query);
            $select->bindParam(":id", $id);
            $select->execute();
            $displayContact = $select->fetch();
            $select->closeCursor();

            //only retreive medical info if account type is EMS or EMS admin
            if($_SESSION['acc_type'] == 2 || $_SESSION['acc_type'] == 3){
                $query = "SELECT * FROM student_medical_info WHERE student_id = :id";
                $select = $db->prepare($query);
                $select->bindParam(":id", $id);
                $select->execute();
                $displayMed = $select->fetch();
                $select->closeCursor();
            }
        }
        else{
            $error_msg = "No user found.";
            include("HomePage.php");
            exit();
        }
    }
    else{
        $error_msg = "Select failed";
        include("HomePage.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>

<head>
	<title>Student Info</title>
	<link rel="stylesheet" href="StudentProfile.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/832441b8c8.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<style>
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
		}
   </style>
</head>
<body> 
	<div class="studentprofile">
		<nav>
			<form id="searchHome" action="searchDB.php" method="post" onsubmit="return validateSearch()">
				<label>Search Student ID Number:</label>
				<input type="number" name="studentID_home" value="">
			</form>
		</nav>
		<div class="information">
            <?php echo "<h1>".$displayUser['first_name']." ".$displayUser["last_name"]."</h1>"; ?>
			<br>
            <?php if($_SESSION['id'] == 2 || $_SESSION['id'] == 3) { ?>
			    <h2>Date of Birth: <?php echo $displayMed['dob']; ?></h2>
                <br>
            <?php } ?>
            <h2>Emergency Contact</h2>
            <h3>Name: <?php echo $displayContact['e_first_name']." ".$displayContact['e_last_name']; ?> </h3>
            <h3>Relation: <?php echo $displayContact['relation']; ?> </h3>
            <h3>Phone Number: <?php echo $displayContact['phone_number']; ?> </h3>
            <br>
            <?php if($_SESSION['id'] == 2 || $_SESSION['id'] == 3) { ?>
			    <h2>Heart Problems: 
                    <?php if($displayMed['heart_problems'] == 1) { 
                        echo "Yes </h2>"; ?> 
                        <h3>Diagnoses and/or medications:</h3>
                        <textarea rows="4" cols="90" readonly>
                            <?php echo $displayMed['heart_problems_medications']; ?>
                        </textarea> <br>
                    <?php } else{ echo "No </h2>"; }?>
                <br>
                <h2>Pacemaker: 
                    <?php if($displayMed['pacemaker'] == 1) { 
                        echo "Yes </h2>"; ?> 
                        <h3>Diagnoses and/or medications:</h3>
                        <textarea rows="4" cols="90" readonly>
                            <?php echo $displayMed['pacemaker_medications']; ?>
                        </textarea><br>
                    <?php } else{ echo "No </h2>"; }?>
                <br>
                <h2>Diabetes: 
                    <?php if($displayMed['diabetes'] == 1) { 
                        echo "Yes </h2>"; ?> 
                        <h3>Diagnoses and/or medications:</h3>
                        <textarea rows="4" cols="90" readonly>
                            <?php echo $displayMed['diabetes_medications']; ?>
                        </textarea><br>
                    <?php } else{ echo "No </h2>"; }?>
                <br>
                <h2>High Blood Pressure: 
                    <?php if($displayMed['high_bp'] == 1) { 
                        echo "Yes </h2>"; ?> 
                        <h3>Diagnoses and/or medications:</h3>
                        <textarea rows="4" cols="90" readonly>
                            <?php echo $displayMed['high_bp_medications']; ?>
                        </textarea><br>
                    <?php } else{ echo "No </h2>"; }?>
                <br>
                <h2>Strokes: 
                    <?php if($displayMed['stroke'] == 1) { 
                        echo "Yes </h2>"; ?> 
                        <h3>Diagnoses and/or medications:</h3>
                        <textarea rows="4" cols="90" readonly>
                            <?php echo $displayMed['stroke_medications']; ?>
                        </textarea><br>
                    <?php } else{ echo "No </h2>"; }?>
                <br>
                <h2>Asthma or COPD: 
                    <?php if($displayMed['asthma_copd'] == 1) { 
                        echo "Yes </h2>"; ?> 
                        <h3>Diagnoses and/or medications:</h3>
                        <textarea rows="4" cols="90" readonly>
                            <?php echo $displayMed['asthma_copd_medications']; ?>
                        </textarea><br>
                    <?php } else{ echo "No </h2>"; }?>
                <br>
                <h2>Seizures: 
                    <?php if($displayMed['seizures'] == 1) { 
                        echo "Yes </h2>"; ?> 
                        <h3>Diagnoses and/or medications:</h3>
                        <textarea rows="4" cols="90" readonly>
                            <?php echo $displayMed['seizures_medications']; ?>
                        </textarea><br>
                    <?php } else{ echo "No </h2>"; }?>
                <br>
                <h2>Cancer: 
                    <?php if($displayMed['cancer'] == 1) { 
                        echo "Yes </h2>"; ?> 
                        <h3>Diagnoses and/or medications:</h3>
                        <textarea rows="4" cols="90" readonly>
                            <?php echo $displayMed['cancer_medications']; ?>
                        </textarea><br>
                    <?php } else{ echo "No </h2>"; }?>
                <br>
                <h2>Allergies: 
                    <?php if($displayMed['allergies'] == 1) { 
                        echo "Yes </h2>"; ?> 
                        <h3>Diagnoses and/or medications:</h3>
                        <textarea rows="4" cols="90" readonly>
                            <?php echo $displayMed['allergies_medications']; ?>
                        </textarea><br>
                    <?php } else{ echo "No </h2>"; }?>
                <br>
                <h2>Other Conditions: 
                    <?php if($displayMed['other'] == 1) { 
                        echo "Yes </h2>"; ?> 
                        <h3>Diagnoses and/or medications:</h3>
                        <textarea rows="4" cols="90" readonly>
                            <?php echo $displayMed['other_medications']; ?>
                        </textarea><br>
                    <?php } else{ echo "No </h2>"; }?>
                <br>
			<?php } ?>
		</div>
	</div>
</body>

</html>
