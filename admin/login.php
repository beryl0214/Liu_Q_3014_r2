<?php

require('../includes/connect.php');
// restart session
session_start();

// if session last login date is not set, exit the admin welcome page
if(isset($_SESSION['admin'])){
    header("Location: /admin/welcome.php");
    exit();
}

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $options = [
        'cost' => 10
    ];

    // query for the user in the database
    $queryUser = "SELECT * FROM admins WHERE username  = '{$username}' LIMIT 1";

    if($user = $connection->query($queryUser)->fetch_object()){

        // check number of attempts
        if($user->attempt >= 3){
            $error =  'Maximum attempts reached, you are locked out!';
        }

        // check password
        if(password_verify($password, $user->password)){
            $_SESSION['lastLogin'] = $user->last_login;
            $_SESSION['admin'] = $user->username;
            $queryUpdateAttempts = "UPDATE admins SET attempt = null, last_login = NOW() WHERE id = {$user->id}";
            $connection->query($queryUpdateAttempts);

            header("Location: /admin/welcome.php");
            die();
        }
        else{
            // if password is wrong, add to attempts
            $newAttempt = $user->attempt + 1;
            $queryUpdateAttempts = "UPDATE admins SET attempt = {$newAttempt} WHERE id = {$user->id}";
            $connection->query($queryUpdateAttempts);
        }
    }
    else{
        // if user is not found, display error
        $error = 'Cannot find user.';
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Beryl's admin login page</title>
</head>
<body>
    <h1>
        Please Log in as admin first:
    </h1>
    <?php
    // display error message
    if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>
    <form action="" method="POST">
        <div>
            <label for="username">
                Username:
            </label>
            <input id="username" name="username" type="text">
        </div>
        <div>
            <label for="password">
                Password:
            </label>
            <input id="password" name="password" type="password">
        </div>
        <div>
            <input type="submit" value="Submit"/>
        </div>
    </form>
</body>
</html>