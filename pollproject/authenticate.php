<?php 

require 'config.php';
session_start();
// var_dump($_POST);

if(!isset($_POST['username'], $_POST['password'])) {
    // could not get data that should have been sent
    exit('please fill both the username and password fields!');
}

//Prepare our SQL, preparing the SQL statement will prevent SQL injection
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username =?')) {
    //Bind parameter (s=string, i=int, b=blob, etc.) in our case the username is a string so we use 's'
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    //Store the result so we can check if the account exists in the database
    $stmt->store_result();

    //authenticate the user
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password. 
        // Note: remember to use password_hash in your registration file to store the hashed password. 
        if (password_verify($_POST['password'], $password)) {
            //Verification success! User has logged-in! 
            //create sessions so we know the user is logged in, they basically act like cookeis but remember the data on 
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            // echo "Welcome " . $_SESSION['name']; 
            header('Location: profile.php');
        } else {
            echo "Incorrect  password.";
        }
    } else {
        echo "Incorrect username.";
    }

    $stmt->close();
}