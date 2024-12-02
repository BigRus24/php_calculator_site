<?php
declare(strict_types=1);


function get_user(object $pdo, string $login_username) {
    // select not only username but every column from within table

    $query = "SELECT * FROM registration WHERE username = :username;";

    $stmt = $pdo -> prepare($query);
    $stmt -> bindParam(":username", $login_username);
    $stmt -> execute();

    // get top result from database
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    echo "username: " . $result['UserName'] . "<br>";
    //echo "user password: " . $result['Passw'] . "<br>";

    return $result;
}