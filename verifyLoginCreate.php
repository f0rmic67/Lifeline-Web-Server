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
        $pass1 = filter_input(INPUT_POST, "password1");
        $pass2 = filter_input(INPUT_POST, "password2");
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
        if($pass1 == ''){
            $error_msg = "Password must be entered.";
        }
        if($pass2 == ''){
            $error_msg = "Password must be entered.";
        }
        if($pass1 != $pass2){
            $error_msg = "Passwords do not match.";
        }

        //if error occurs, redirect to login page and display error message
        if($error_msg != ''){
            include("logAndreg.php");
            exit();
        }
        else{
            //search DB for existing account with the same information
            
            //create account entry in database
            $query = "INSERT INTO student_user(student_id, email, pass, username) VALUES (:id, :email, :pass, :username)";
            $insert = $db->prepare($query);
            $insert->bindParam(":id", $id);
            $insert->bindParam(":email", $email);
            $insert->bindParam(":pass", $pass1);
            $insert->bindParam(":username", $username);

            //debugging output
            if($insert->execute()){
                echo "Insert successful";
                //add profile info to $_SESSION array for account type + user validation in other pages
                header("Location:HomePage.html");
                exit();
            }
            else{
                echo "Insert failed";
                //add error message
                include("logAndreg.php");
                exit();
            }
        }
    }
    //validate input and query database to confirm account credentials
    else if($action == "login"){
        $username = filter_input(INPUT_POST, "username");
        $pass = filter_input(INPUT_POST, "password");

        if($username == ''){
            $error_msg = "Username must be entered.";
        }
        if($pass == ''){
            $error_msg = "Password must be entered.";
        }
        else{
            $search = "SELECT * FROM student_user WHERE username = :username AND pass = :pass;";
            $searchQuery = $db->prepare($search);
            $searchQuery->bindParam(":username", $username);
            $searchQuery->bindParam(":pass", $pass);

            if($searchQuery->execute()){
                $account = $searchQuery->fetchAll();
                $searchQuery->closeCursor();
                
                if($account && $username == $account[0]['username'] && $pass == $account[0]["pass"]){
                    echo "login successful";
                    //add account info to $_SESSION array
                    header("Location:HomePage.html");
                    exit();
                }
                else{
                    echo "login failed";
                }
            }
            else{
                echo "Query failed";

            }
        }
    }
?>