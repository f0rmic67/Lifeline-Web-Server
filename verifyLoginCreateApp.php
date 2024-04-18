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
            
        }
        else{
            //search DB for existing account with the same information
            $query = "SELECT * FROM user WHERE username = :username OR email = :email OR id = :id";
            $search = $db->prepare($query);
            $search->bindParam(":username", $username);
            $search->bindParam(":email", $email);
            $search->bindParam(":id", $id);
            $search->execute();
            $account = $search->fetchAll();
            $search->closeCursor();

            //if account with matching credentials already exists, give error message and exit
            //not working yet
            
            if(!empty($account)){
                $error_msg = "Account credentials already in use, please use unique credentials.";
                
            }
            else{
                //create account entry in database

                //if creating EMS account, check table for matching EMS ID
                if($accType == 2){
                    $query = "SELECT * FROM ems_employees WHERE ems_id = :ems_id";
                    $check = $db->prepare($query);
                    $check->bindParam(":ems_id", $id);
                    $check->execute();
                    $match = $check->fetch();

                    //return to login page without creating account if ID is not valid
                    if(empty($match)){
                        $error_msg = "Account creation failed, EMS ID is not registered as a valid EMS employee.";
                        
                    }
                }

                $query = "INSERT INTO user(id, email, pass, username, account_type) VALUES (:id, :email, :pass, :username, :acc_type)";
                $insert = $db->prepare($query);
                $insert->bindParam(":id", $id);
                $insert->bindParam(":email", $email);
                $insert->bindParam(":pass", $pass1);
                $insert->bindParam(":username", $username);
                $insert->bindParam(":acc_type", $accType);

                //debugging output
                if($insert->execute()){
                    echo "Insert successful";
                    //add profile info to $_SESSION array for account type + user validation in other pages
                    $_SESSION['id'] = $id;
                    $_SESSION['acc_type'] = $accType;

                    //create medical and emergency contact tables if student account
                    if($accType == 1){
                        $query = "INSERT INTO student_medical_info(student_id, id) VALUES (:id, :id)";
                        $insert = $db->prepare($query);
                        $insert->bindParam("id", $id);
                        $insert->execute();

                        $query = "INSERT INTO emergency_contacts(student_id, id) VALUES (:id, :id)";
                        $insert = $db->prepare($query);
                        $insert->bindParam("id", $id);
                        $insert->execute();
                    }

                    if($accType == 2){
                        $query = "UPDATE user SET first_name = :fname, last_name = :lname WHERE id = :id";
                        $update = $db->prepare($query);
                        $update->bindParam(":fname", $match['fname']);
                        $update->bindParam(":lname", $match['lname']);
                        $update->bindParam(":id", $id);
                        $update->execute();
                    }

                }
                else{
                    $error_msg = "Account creation failed.";
                    
                }
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
            $search = "SELECT * FROM user WHERE username = :username AND pass = :pass;";
            $searchQuery = $db->prepare($search);
            $searchQuery->bindParam(":username", $username);
            $searchQuery->bindParam(":pass", $pass);

            if($searchQuery->execute()){
                $account = $searchQuery->fetchAll();
                $searchQuery->closeCursor();
                
                if($account && $username == $account[0]['username'] && $pass == $account[0]["pass"]){
                    echo "login successful";
                    //add account info to $_SESSION array for reference on other pages
                    $_SESSION['id'] = $account[0]['id'];
                    $_SESSION['acc_type'] = $account[0]['account_type'];
                    //maybe create logged_in session token for checking if a user is logged in
                    //could also just check if username or acc type are set, but may be more readable later
                    //maybe set acc_type to 0 if not logged in 
                    
                }
                else{
                    $error_msg = "Login failed, no account with entered credentials found.";
                    
                }
            }
            else{
                echo "Query failed";

            }
        }
    }
?>