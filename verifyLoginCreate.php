<?php
    //start PHP session for cross-page global data
    $status = session_status();
	if($status == PHP_SESSION_NONE){
		session_start();
	}

    require_once("db_connect.php");

    $error_msg = '';
    $action = filter_input(INPUT_POST, 'submit');

    //validate input and query database to create account table entry 
    if($action == "createAccount"){
        $username = filter_input(INPUT_POST, "username");
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $password1 = filter_input(INPUT_POST, "password1");
        $password2 = filter_input(INPUT_POST, "password2");
        $accType = filter_input(INPUT_POST, "accType");

        if($username == ''){
            $error_msg = "Username must be entered.";
        }
        if($email == ''){
            $error_msg = "Email must be entered.";
        }
        if($email == FALSE){
            $error_msg = "Email not valid.";
        }
        if($id == ''){
            $error_msg = "ID number must be entered.";
        }
        if($id == FALSE){
            $error_msg = "ID number not valid.";
        }
        if($password1 == ''){
            $error_msg = "Password must be entered.";
        }
        if($password2 == ''){
            $error_msg = "Password must be entered.";
        }
        if($password1 != $password2){
            $error_msg = "Passwords do not match.";
        }

        //if error occurs, redirect to login page and display error message
        if($error_msg != ''){
            include("logAndreg.php");
            exit();
        }
        else{
            //search DB for existing account with the same information
            var_dump($_SESSION);
            //create account entry in database
            $query = "INSERT INTO student_user(student_id, email, password, username) VALUES (:id, :email, :password, :username)";
            $insert = $db->prepare($query);
            $insert->bindParam(":id", $id);
            $insert->bindParam(":email", $email);
            $insert->bindParam(":password", $password);
            $insert->bindParam(":username", $username);

            //debugging output
            if($insert->execute()){
                echo "Insert successful";
            }
            else{
                echo "Insert failed";
            }
        }
    }
    //validate input and query database to confirm account credentials
    else if($action == "login"){
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");

        if($username == ''){
            $error_msg = "Username must be entered.";
        }
        if($password == ''){
            $error_msg = "Password must be entered.";
        }

    }
?>