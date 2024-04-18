<?php
	require_once("db_connect.php");

	$query = "SELECT * FROM ems_employees";
	$select = $db->prepare($query);
	$select->execute();
	$employees = $select->fetchAll();
	$select->closeCursor();
?>

<!DOCTYPE html>
<html>

<head>
	<title>File Upload</title>
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
		<div class="information">
			<h2>Registered Employees</h2>
			<?php if(empty($employees)){
				echo "No employees registered.";
			}
			else{
				echo "<table><tr><th>EMS ID</th><th>First Name</th><th>Last Name</th></tr>";
				foreach($employees as $employee){
					echo "<tr>";
					echo "<td>".$employee['ems_id']."</td>";
					echo "<td>".$employee['fname']."</td>";
					echo "<td>".$employee['lname']."</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			?>
			<br>
			<h2>Add New Employee</h2>
			<form action="upload.php" method="post">
				<label>ID Number: </label>
				<input type="number" name="ems_id"><br>
				<label>First Name:</label>
				<input type="text" name="fname"><br>
				<label>Last Name: </label>
				<input type="text" name="lname"><br>
				<input type="submit" name="action" value="Add Employee">
			</form>
		</div>
	</div>
</body>

</html>
