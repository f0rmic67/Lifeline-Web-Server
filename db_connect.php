<?php
    //start PHP session for cross-page global data
    $status = session_status();
	if($status == PHP_SESSION_NONE){
		session_start();
	}

    $dsn = 'mysql:host=ls-3b7e6f89b80f6a9ff2d02a1394dd18e58f481247.cl444yoq0gck.us-east-2.rds.amazonaws.com;';
    $username = 'dbmasteruser';
    $password = 'Lifeline2024';

    //output connection status for debugging
    try {
        $db = new PDO($dsn, $username, $password); //creates PDO
        $_SESSION['db'] = $db;
        echo '<p> You are connected. </p>';
    }
    catch (PDOException $e){
        $error_message = $e->getMessage();
        echo '<p> Connection failed due to error : $error_message </p>';
    }
?>