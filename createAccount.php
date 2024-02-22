<?php
    //create PHP session for storing user info between pages
    $status = session_status();
    if($status == PHP_SESSION_NONE){
        session_start();
    }

    //connect to database
    $dsn = 'mysql:host=ls-3b7e6f89b80f6a9ff2d02a1394dd18e58f481247.cl444yoq0gck.us-east-2.rds.amazonaws.com;dbname=Database-1'; 
    $username = 'dbmasteruser';
    $password = 'Lifeline2024';

    try {
        $db = new PDO($dsn, $username, $password); //creates PDO
        echo '<p> You are connected. </p>';
    }
    catch (PDOException $e){
        $error_message = $e->getMessage();
        echo '<p> Connection failed due to error : $error_message </p>';
    }

    $action = filter_input(INPUT_GET, 'accSubmit');

    if($action == "Create Student Account"){
        //get each user input field from html and verify data 
        $accountType = 1; //student account type = int 1
        $username = filter_input(INPUT_GET, 'sUser');
        $email = filter_input(INPUT_GET, 'sEmail', FILTER_VALIDATE_EMAIL);
        $id = filter_input(INPUT_GET, "sID", FILTER_VALIDATE_INT);
        $password = filter_input(INPUT_GET, "sPass1");
    }
    else if($action == "Create EMS Account"){
        $accountType = 2; //EMS account type = int 2
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Account</title>
        <link rel="stylesheet" type="text/css" href="main.css">

        <script type="text/javascript" src="functions.js"></script>
    </head>
    
    <body>
        <h1>Lifeline</h1>
        <br>
        <br>
        <h2>Create Account</h2>
        <br>
        <br>
        <label>Account Type:</label>
        <select id="accType" onchange="accountType()">
            <option value="student">Student</option>
            <option value="ems">EMS</option>
        </select>
        <br>

        <!--forms will hide and display based on user input for account type-->

        <form id="studentForm" onsubmit="validateStudent()" action="createAccount.html" method="get" style="display:block">
            <label>Username:</label>
            <input type="text" name="sUser" value="">
            <br>
            <br>
            <label>Email:</label>
            <input type="text" name="sEmail" value="">
            <br>
            <br>
            <label>ID Number:</label>
            <input type="number" name="sID" value="">
            <br>
            <br>
            <label>Password:</label>
            <input type="password" name="sPass1" value="">
            <br>
            <br>
            <label>Re-Enter Password:</label>
            <input type="password" name="sPass2" value="">
            <br>
            <br>
            <input type="submit" name="accSubmit" value="Create Student Account">
        </form>

        <form id="emsForm" onsubmit="validateEMS()" style="display:none">
            <label>Username:</label>
            <input type="text" name="sUser" value="">
            <br>
            <br>
            <label>Email:</label>
            <input type="text" name="sEmail" value="">
            <br>
            <br>
            <label>EMS ID:</label>
            <input type="text" name="sID" value="">
            <br>
            <br>
            <label>Password:</label>
            <input type="password" name="sPass1" value="">
            <br>
            <br>
            <label>Re-Enter Password:</label>
            <input type="password" name="sPass2" value="">
            <br>
            <br>
            <input type="submit" name="accSubmit" value="Create EMS Account">
        </form>
    </body>
</html>