<?php
	require_once("db_connect.php");

	if(!isset($error_msg)) {$error_msg = '';}

	if($error_msg != ''){
		echo "<script>alert('$error_msg');</script>";
	}
?>

<html>
<head>
	<title>Login and Registration Form</title>
	<link rel="stylesheet" href="logAndreg.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/832441b8c8.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="hero">
		<div class="back">
			<a href="HomePage.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
		</div>
		<div class="form-box">
			<div class="button-box">
				<div id="btn"></div>
				<button type="button" class="toggle-btn" onclick="login()">Login</button>
				<button type="button" class="toggle-btn" onclick="register()">Register</button>
			</div>
			<div class="login">
				<form id="loginPage" class="input-group" action="verifyLoginCreate.php" method="post">
					<input type="text" class="input-box" name="username" placeholder="Username" required>	
					<input type="password" class="input-box" name="password" placeholder="Password" required>
					<input type="checkbox" class="check-box"><span>Remember Me</span>
					<button type="submit" name="submit" class="submit-btn" value="login">Login</button>
					<a href="">Forgot Password</a>
				</form>
			</div>
			<div class="register">
				<form id="registerPage" class="input-group" action="verifyLoginCreate.php" method="post">
					<select id="accType" name="accType" onchange="accountType()">
						<option class="hidden" selected disabled>Please select an Account Type</option>
						<option value="1">Student Account</option>
						<option value="2">EMS Account</option>
					</select>
					
					
						<input type="text" class="input-box" name="username" placeholder="Username" required>		
						<input type="email" class="input-box" name="email" placeholder="Your Email Address" required>
						<input type="number" class="input-box" name="id" placeholder="ID Number" required>
						<input type="password" class="input-box" name="password1" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
						title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
						<input type="password" class="input-box" name="password2" placeholder="Re-Enter Password" required>
						<input type="checkbox" class="check-box"><span>I agree to the <a href="">Terms & Conditions</a></span>
						<button type="submit" name="submit" class="submit-btn" value="createAccount">Register</button>
					
				</form>
			</div>
			
		</div>
		<h2>Please contact lifeline.senior.project@gmail.com to request an admin account</h2>
	</div>
	<script src="myFunction.js"></script>
</body>
