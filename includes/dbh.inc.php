<?php

$sql_dsn='mysql:host=localhost;dbname=project';
$sql_username='root';
$sql_password='root';


try {
    $pdo= new PDO($sql_dsn,$sql_username,$sql_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: ".$e->getMessage();
}