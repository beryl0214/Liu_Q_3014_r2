<?php
    session_start();

    // if session last login date is not set, exit the admin welcome page
    if(!isset($_SESSION['admin'])){
        header("Location: /admin/login.php");
        exit();
    }

    //set time zone;
    date_default_timezone_set('America/Toronto');

    // now set the welcome message base on the current time
    $currentHour = date('H');
    $welcomeMessage = 'Welcome to the admin page, ';

    // set the welcome message base on the current hour
    switch($currentHour){
        case $currentHour < 12:
            $welcomeMessage .= 'and have a good morning!';
            break;

        case $currentHour < 18:
            $welcomeMessage .= 'and have a great afternoon!';
            break;

        default:
            $welcomeMessage .= 'and have a lovely evening!';
            break;
    }
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Beryl's admin page</title>
</head>
<body>
<?php
// display last login date
if (isset($_SESSION['lastLogin']) && $_SESSION['lastLogin'] != null) {
    echo "<p>Last login date: {$_SESSION['lastLogin']}</p>";
}

// display the welcome message
echo "<h1>$welcomeMessage</h1>";
?>
<h2>Add User</h2>
<hr>
<form method="post" action="create_user.php">
    <label for="username">Username: </label>
    <input type="text" name="username" id="username">

    <label for="email">Email: </label>
    <input type="email" name="email" id="email">

    <button type="submit">Add</button>
</form>

<a href="/logout.php">Logout</a>
</body>
</html>
