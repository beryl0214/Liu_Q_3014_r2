<?php
require '../vendor/autoload.php';
require('../includes/connect.php');

if(isset($_POST['username']) && isset($_POST['email'])){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = mt_rand(); // Ref: http://php.net/manual/en/function.mt-rand.php
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql_create_user = "INSERT INTO users (username, password) VALUES ('{$username}', '$hashed_password')";
    $result = $connection->query($sql_create_user);

    if ($result) { // Send email to the user
        $from = new SendGrid\Email(null, "q_liu20@fanshaweonline.ca");
        $subject = "Your account is ready to use!";
        $to = new SendGrid\Email(null, $email);
        $text = "Username: " . $username . "<br>";
        $text .= "Password: " . $password . "<br>";
        $text .= "Login URL: https://liu-q-3014-r2.herokuapp.com";
        $content = new SendGrid\Content("text/html", $text);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);

        $apiKey = getenv('SENDGRID_API_KEY');
        $sg = new \SendGrid($apiKey);

        $response = $sg->client->mail()->send()->post($mail);
        header("Location: /admin/welcome.php");
        die();
    }
}
?>