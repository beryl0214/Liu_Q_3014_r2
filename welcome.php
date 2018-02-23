<?php
    session_start();

    // if session last login date is not set, exit the admin welcome page
    if(!isset($_SESSION['lastLogin'])){
        header("Location: /");
        exit();
    }

    //set time zone;
    date_default_timezone_set('America/Toronto');

    // now set the welcome message base on the current time
    $currentHour = date('H');
    $welcomeMessage = 'Welcome ' . $_SESSION['username'] . ', ';

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
<a href="/logout.php">Logout</a>
</body>
</html>
