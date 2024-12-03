<?php
declare(strict_types=1);


function get_user(object $pdo, string $login_username) {
    $query = "SELECT * FROM registration WHERE username = :username;";

    $stmt = $pdo -> prepare($query);
    $stmt -> bindParam(":username", $login_username);
    $stmt -> execute();

    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    echo "username: " . $result['UserName'] . "<br>";

    return $result;
}