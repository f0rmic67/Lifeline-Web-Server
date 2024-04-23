<?php
    $status = session_status();
    if($status == PHP_SESSION_NONE){
        session_start();
    }

    require_once("db_connect.php");

    $query = "SELECT * FROM recent_lookups ORDER BY search_time";
    $select = $db->prepare($query);
    $select->execute();
    $recent = $select->fetchAll();
    $select->closeCursor();
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
            <table id="recent">
                <tr>
                    <th>Searched Student ID</th>
                    <th>Search Time</th>
                </tr>
                <?php foreach($recent as $lookup){ 
                    echo "<tr>";
                    echo "<td>".$lookup["student_id"]."</td>";
                    echo "<td>".$lookup["search_time"]."</td>";
                    
                    echo "<td><form action='searchDisplayUser.php' method='post'><input type='hidden' name='id' value=".$lookup["student_id"].
                        "><input type='submit' value='View Details'>";
                    echo "</tr>";
                }
                ?>
            </table>
		</div>
	</div>
</body>

</html>
