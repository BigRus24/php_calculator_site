<?php
declare(strict_types=1);

function check_signup_errors()
{
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        echo "<br>";

        foreach ($errors as $error) {
            echo '<p class="form-error"></p>' . $error . '</p>';
        }

        unset($_SESSION['errors_signup']);
    }
}
function get_username(object $pdo, string $signup_username)
{
    $query = "SELECT username FROM registration WHERE username = :username;";
    // send in query separately; separate user from query
    // prevents SQL injection
    $stmt = $pdo -> prepare($query);
    $stmt -> bindParam(":username", $signup_username);

    // query database using execute statement
    $stmt -> execute();

    // grab only 1 piece of data from database (different from fetchall)
    // fetch as FETCH_ASSOC - meaning associative array; means we refer
    // refer to the data ; we can basically take this data and return it
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    echo "result:" . $result . "<br>";

    // return the variable as result. Which means when we run this function,
    // we grab data OR when the username does NOT exist, we get a false statement
    return $result;
}

function get_email(object $pdo, string $signup_email)
{
    $query = "SELECT email FROM registration WHERE email = :email;";
    // send in query separately; separate user from query
    // prevents SQL injection
    $stmt = $pdo -> prepare($query );
    $stmt -> bindParam(":email", $signup_email);

    // query database using execute statement
    $stmt -> execute();

    // grab only 1 piece of data from database (different from fetchall)
    // fetch as FETCH_ASSOC - meaning associative array; means we refer
    // refer to the data ; we can basically take this data and return it
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);

    // return the variable as result. Which means when we run this function,
    // we grab data OR when the username does NOT exist, we get a false statement
    return $result;
}

function set_user(object $pdo, string $signup_username, string $signup_password, string $signup_email)
{
    // grab connection to database
    echo "username: " | $signup_username | "<br>";

    require_once "dbh.inc.php";
    require_once 'manualHashing.inc.php';
    echo "Begin insert. <br>";
    $query="INSERT INTO registration (username, email, passw, salt) VALUES (:username, :email, :passw, :salt);";
    
    $stmt = $pdo->prepare($query);

    /*$options=[
        'cost' => 12
    ];*/
    $salt = bin2hex(random_bytes(16));
    //$hashedPassw= password_hash($signup_password, PASSWORD_BCRYPT);
    $hashedPassw = manualHash($signup_password, $salt);
    //$hashedPassw= $signup_password;

    $stmt->bindParam(":username",$signup_username);
    $stmt->bindParam(":passw",$hashedPassw);
    $stmt->bindParam(":email",$signup_email);
    $stmt->bindParam(":salt",$salt);

    $stmt->execute();
    echo "End insert. <br>";
}