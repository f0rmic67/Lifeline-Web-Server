<?php
    $dsn = 'mysql:host=ls-3b7e6f89b80f6a9ff2d02a1394dd18e58f481247.cl444yoq0gck.us-east-2.rds.amazonaws.com;dbname=Lifeline;';
    $username = 'dbmasteruser';
    $password = 'Lifeline2024';

    //output connection status for debugging
    try {
        $db = new PDO($dsn, $username, $password); //creates PDO
    }
    catch (PDOException $e){
        $error_message = $e->getMessage();
        echo '<p> Connection failed due to error</p>';
    }
?>