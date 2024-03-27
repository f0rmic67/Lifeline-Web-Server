<?php
	//start PHP session for cross-page global data
	$status = session_status();
	if($status == PHP_SESSION_NONE){
		session_start();
	}

	if(!isset($_SESSION['acc_type'])){
		$_SESSION['acc_type'] = 0;
	}
	
	if(!isset($error_msg)) {$error_msg = '';}

	if($error_msg != ''){
		echo "<script>alert('$error_msg');</script>";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LifeLine</title>
	<link rel="stylesheet" href="style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/832441b8c8.js" crossorigin="anonymous"></script>
</head>
<body>
<section class="header">
	<nav>
		<a href="test.html"><img src="images/LifeLineLogo2.png"></a>
		<div class="nav-links"id="navLinks">
			<i class="fa-solid fa-xmark" onclick="hideMenu()"></i>
			<ul>
				<li><a href="HomePage.php">HOME</a></li>
				<?php if($_SESSION['acc_type'] == 0){ ?>
					<li><a href="logAndreg.php">LOGIN</a></li>
				<?php } else{ ?>
					<li><a href="logout.php">LOG OUT</li>
				<?php } ?>
				<li><a href="">ABOUT</a></li>
			</ul>
		</div>
		<i class="fa-solid fa-bars" onclick="showMenu()"></i>
	</nav>
	
<div class="text-box">
	<h1>LifeLine</h1>
	<p>Changing the way first responders gain information in an emergency.</p>
	<br>
	<form id="search" action="searchDisplayUser.php" method="post">
		<label>Look Up Student ID</label>
		<input type="number" class="input-box" name="id" placeholder="ID Number" required>
	</form>
	<br>
	<?php if($_SESSION['acc_type'] == 1) { ?>
		<a href="StudentProfile.php" class="hero-btn">Upload Emergency Information</a>
	<?php } else if($_SESSION['acc_type'] == 2 || $_SESSION['acc_type'] == 3) {?>
		<a href="" class="hero-btn">See Recent Lookups</a>
	<?php } if($_SESSION['acc_type'] == 3) { ?>
		<br><br><a href="" class="hero-btn">Upload Department EMS Credential Sheet</a>
	<?php } ?>

</div>
</section>

<!----------information--------------->
<section class="information">
	<h1>LifeLine Information</h1>
	<p>Some information about LifeLine</p>
	
	<div class="row">
		<div class="account-type">
			<h3>Student Account</h3>
			<p>A student account can...</p>
		</div>
		<div class="account-type">
			<h3>EMS Account</h3>
			<p>An EMS account can...</p>
		</div>
		<div class="account-type">
			<h3>Administrator Account</h3>
			<p>An administrator account can...</p>
		</div>
	</div>
</section>

<!---------Campus-------->
<section class="campus">
	<h1>Pennwest Campuses</h1>
	<p>These are the Pennwest Campuses</p>
	
	<div class="row">
		<div class="cal-campus">
			<img src="images/CalCampus.png">
			<div class="label">
				<h3>California Campus</h3>
			</div>
		</div>
		<div class="cal-campus">
			<img src="images/PennwestClarCampus.png">
			<div class="label">
				<h3>Clarion Campus</h3>
			</div>
		</div>
		<div class="cal-campus">
			<img src="images/PennwestEdinCampus.jpg">
			<div class="label">
				<h3>Edinboro Campus</h3>
			</div>
		</div>
	</div>
</section>

<!-----------Contact Us--------------->
<section class="contact">
	<h1>Questions or concerns?<br>Click the button to share with us</h1>
	<a href="" class="hero-btn">CONTACT US</a>
</section>

<!--------- Footer ------------>
<section class="footer">
	<h4>About Us</h4>
	<p>fhasjdfkaskfsjfhsjfhsdjf</p>
	<div class="icons">
		<i class="fa-brands fa-facebook"></i>
		<i class="fa-brands fa-x-twitter"></i>
		<i class="fa-brands fa-instagram"></i>
		<i class="fa-brands fa-linkedin"></i>
	</div>
	<p>Made by Joshua Panaro, Jeremiah Neff, Anthony Stepich, and
	Christian Beatty</p>
</section>


<!----------JavaScript for Toggle Menu-------------->
<script src="myFunction.js"></script>

</body>
</html>