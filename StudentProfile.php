<?php
	//start PHP session for cross-page global data
    $status = session_status();
	if($status == PHP_SESSION_NONE){
		session_start();
	}

	require_once("db_connect.php");

	//pull existing emergency info from table and populate fields
	$search = "SELECT * FROM student_medical_info WHERE student_id = :id";
	$searchMed = $db->prepare($search);
	$searchMed->bindParam(":id", $_SESSION['id']);
	if($searchMed->execute()){
		$existingInfo = $searchMed->fetchAll();
	}
	
	//pull student account info
	$search = "SELECT first_name, last_name, username FROM user WHERE id = :id";
    $searchQuery = $db->prepare($search);
    $searchQuery->bindParam(":id", $_SESSION['id']);
	if($searchQuery->execute()){
		$account = $searchQuery->fetchAll();
		$searchQuery->closeCursor();
	}

	//pull emergency contact info
	$search = "SELECT * FROM emergency_contacts WHERE id = :id";
	$searchQuery = $db->prepare($search);
	$searchQuery->bindParam(":id", $_SESSION['id']);
	if($searchQuery->execute()){
		$emergency = $searchQuery->fetchAll();
		$searchQuery->closeCursor();
	}
?>

<html>
<head>
	<title>Student Profile</title>
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
			<?php echo "<h1>".$account[0]['username']."</h1>"; ?>
			<form id="searchHome" action="searchDB.php" method="post" onsubmit="return validateSearch()">
				<label>Search Student ID Number:</label>
				<input type="number" name="studentID_home" value="">
			</form>
		</nav>
		<div class="information">
			<script src="myFunction.js"></script>
			<form id="accountinformation" action="EmergencySubmit.php" method="post" class="input-group">
				<label>First Name:</label>
				<input type="text" class="input-box" name="fname" id="first_name" value="<?php if($account[0]['first_name'] != '') {echo $account[0]['first_name']; } ?>" required ><br>
				
				<label>Last Name:</label>
				<input type="text" class="input-box" name="lname" id="last_name" value="<?php if($account[0]['last_name'] != '') {echo $account[0]['last_name']; } ?>" required><br>
				
				<label>Date of Birth:</label>
				<input type="date" class="input-box" placeholder="Date of Birth" name="dob" id="dob" value="<?php if($existingInfo[0]['dob'] != '') {echo $existingInfo[0]['dob']; } ?>" required><br>
				
				<label>Have you been diagnosed with heart problems?</label>
				<select name="heartProblems" id="heart_problems" onchange="heartProblems()">
					<option value="0">No</option>
					<option value="1" <?php if($existingInfo[0]['heart_problems'] == 1) { ?> selected="selected" <?php } ?> >Yes</option>
				</select><br>
				<label>If yes, heart problem and any medications:</label><br>
				<textarea name="heartProblem" id="heart_problems_medications" rows="4" cols="90"><?php if($existingInfo[0]['heart_problems_medications'] != '') {echo $existingInfo[0]['heart_problems_medications']; } ?></textarea><br>
				
				<label>Do you use a pacemaker?</label>
				<select name="pacemakers" id="pacemaker" onchange="pacemakers()">
					<option value="0">No</option>
					<option value="1" <?php if($existingInfo[0]['pacemaker'] == 1) { ?> selected="selected" <?php } ?> >Yes</option>
				</select><br>
				<label>If yes, any pacemaker medications:</label><br>
				<textarea name="pacemaker" id="pacemaker_medications" rows="4" cols="90" ><?php if($existingInfo[0]['pacemaker_medications'] != '') {echo $existingInfo[0]['pacemaker_medications']; } ?></textarea><br>
				
				<label>Have you been diagnosed with diabetes?</label>
				<select name="diabetes" id="diabetes" onchange="diabetes()">
					<option value="0">No</option>
					<option value="1" <?php if($existingInfo[0]['diabetes'] == 1) { ?> selected="selected" <?php } ?> >Yes</option>
				</select><br>
				<label>If yes, diabetes type and any medications:</label><br>
				<textarea name="diabete" id="diabetes_medications" rows="4" cols="90" ><?php if($existingInfo[0]['diabetes_medications'] != '') {echo $existingInfo[0]['diabetes_medications']; } ?></textarea><br>
				
				<label>Have you been diagnosed with high blood pressure?</label>
				<select name="highBloodPressure" id="high_bp" onchange="highBloodPressure()">
					<option value="0">No</option>
					<option value="1" <?php if($existingInfo[0]['high_bp'] == 1) { ?> selected="selected" <?php } ?>>Yes</option>
				</select><br>
				<label>If yes, any high blood pressure medications:</label><br>
				<textarea name="highBP" id="high_bp_medications" rows="4" cols="90" ><?php if($existingInfo[0]['high_bp_medications'] != '') {echo $existingInfo[0]['high_bp_medications']; } ?></textarea><br>
				
				<label>Have you ever had a stroke?</label>
				<select name="Strokes" id="stroke" onchange="Strokes()">
					<option value="0">No</option>
					<option value="1" <?php if($existingInfo[0]['stroke'] == 1) { ?> selected="selected" <?php } ?> >Yes</option>
				</select><br>
				<label>If yes, any stroke medications:</label><br>
				<textarea name="stroke" id="stroke_medications" rows="4" cols="90" ><?php if($existingInfo[0]['stroke_medications'] != '') {echo $existingInfo[0]['stroke_medications']; } ?></textarea><br>
				
				<label>Do you have asthma or COPD?</label>
				<select name="Asthma" id="asthma_copd" onchange="Asthma()">
					<option value="0">No</option>
					<option value="1" <?php if($existingInfo[0]['asthma_copd'] == 1) { ?> selected="selected" <?php } ?> >Yes</option>
				</select><br>
				<label>If yes, any asthma or COPD medications:</label><br>
				<textarea name="asthma" id="asthma_copd_medications" rows="4" cols="90" ><?php if($existingInfo[0]['asthma_copd_medications'] != '') {echo $existingInfo[0]['asthma_copd_medications']; } ?></textarea><br>
				
				<label>Have you ever had a seizure?</label>
				<select name="Seizures" id="seizures" onchange="Seizures()">
					<option value="0">No</option>
					<option value="1" <?php if($existingInfo[0]['seizures'] == 1) { ?> selected="selected" <?php } ?> >Yes</option>
				</select><br>
				<label>If yes, any seizure medications:</label><br>
				<textarea name="seizure" id="seizures_medications" rows="4" cols="90" ><?php if($existingInfo[0]['seizures_medications'] != '') {echo $existingInfo[0]['seizures_medications']; } ?></textarea><br>
				
				<label>Have you ever been diagnosed with cancer?</label>
				<select name="Cancer" id="cancer" onchange="Cancer()">
					<option value="0">No</option>
					<option value="1" <?php if($existingInfo[0]['cancer'] == 1) { ?> selected="selected" <?php } ?> >Yes</option>
				</select><br>
				<label>If yes, type and any medications:</label><br>
				<textarea name="cancer" id="cancer_medications" rows="4" cols="90" ><?php if($existingInfo[0]['cancer_medications'] != '') {echo $existingInfo[0]['cancer_medications']; } ?></textarea><br>
				
				<label>Do you have any allergies?</label>
				<select name="Allergies" id="allergies" onchange="Allergies()">
					<option value="0">No</option>
					<option value="1" <?php if($existingInfo[0]['allergies'] == 1) { ?> selected="selected" <?php } ?> >Yes</option>
				</select><br>
				<label>If yes, allergies and medications:</label><br>
				<textarea name="allergy" id="allergies_medications" rows="4" cols="90" ><?php if($existingInfo[0]['allergies_medications'] != '') {echo $existingInfo[0]['allergies_medications']; } ?></textarea><br>
				
				<label>Is there anything else medical related you would like to share?</label>
				<select name="Other" id="other" onchange="Other()">
					<option value="0">No</option>
					<option value="1" <?php if($existingInfo[0]['other'] == 1) { ?> selected="selected" <?php } ?> >Yes</option>
				</select><br>
				<label>If yes, what other conditions and medications:</label><br>
				<textarea name="other" rows="4" cols="90" ><?php if($existingInfo[0]['other_medications'] != '') {echo $existingInfo[0]['other_medications']; } ?></textarea><br>
				<br>
				<h3>Emergency Contact</h3><br>
				<label>First Name:</label>
				<input type="text" class="input-box" name="efname" id="e_first_name" value="<?php if($emergency[0]['e_first_name'] != '') {echo $emergency[0]['e_first_name']; } ?>" required><br>
				<label>Last Name:</label>
				<input type="text" class="input-box" name="elname" id="e_last_name" value="<?php if($emergency[0]['e_last_name'] != '') {echo $emergency[0]['e_last_name']; } ?>" required><br>
				<label>Relation: </label>
				<input type="text" class="input-box" name="relation" id="relation" value="<?php if($emergency[0]['relation'] != '') {echo $emergency[0]['relation']; } ?>" required><br>
				<label for="cphone_number">Enter their phone number:</label>
				<input type="tel" class="phoneNum" name="phone" id="phone_number" value="<?php if(!empty($emergency[0]['phone_number'])) {echo $emergency[0]['phone_number']; } ?>" placeholder="###-###-####" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
			
				<button type="submit" class="submit-btn">Save Information</button>
			</form>
		</div>
	</div>
</body>
</html>