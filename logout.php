<?php
    //start PHP session for cross-page global data
	$status = session_status();
	if($status == PHP_SESSION_NONE){
		session_start();
	}

    $_SESSION['acc_type'] = 0;
    $_SESSION['id'] = 0;

    header("Location:HomePage.php");
    exit();
?>