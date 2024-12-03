<?php
declare(strict_types=1);

function check_signup_errors() {
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        echo "<br>";

        foreach ($errors as $error) {
            echo '<p class="form-error"></p>' . $error . '</p>';
        }

        unset($_SESSION['errors_signup']);
    }
}
function get_username(object $pdo, string $signup_username) {
    $query = "SELECT username FROM registration WHERE username = :username;";

    $stmt = $pdo -> prepare($query);
    $stmt -> bindParam(":username", $signup_username);
    $stmt -> execute();
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    echo "result:" . $result . "<br>";
    return $result;
}

function get_email(object $pdo, string $signup_email) {
    $query = "SELECT email FROM registration WHERE email = :email;";
    $stmt = $pdo -> prepare($query );
    $stmt -> bindParam(":email", $signup_email);
    $stmt -> execute();
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);

    return $result;
}

function set_user(object $pdo, string $signup_username, string $signup_password, string $signup_email) {
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