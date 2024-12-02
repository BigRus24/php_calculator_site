<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo print_r($_POST);

    try {
        require_once 'dbh.inc.php';
        require_once 'admin_model.inc.php';
        require_once 'admin_contr.inc.php';

        if (!isset($_SESSION['username']) or !$_SESSION['admin']) {
            header('Location: ../home.php');
            exit();
        }

        $table = $_POST["table"];
        $first_id = $_POST["first_id"];
        $id = $_POST["id"];

        unset($_POST["first_id"]);
        unset($_POST["id"]);
        unset($_POST["table"]);

        if (isset($_POST["create-row"])) {
            unset($_POST["create-row"]);
            create_row($pdo, $table, $_POST);

        } elseif (isset($_POST["delete-row"])) {
            unset($_POST["delete-row"]);
            delete_row($pdo, $table, $id);

        } elseif (isset($_POST["update-row"])) {
            unset($_POST["update-row"]);
            update_row($pdo, $table, $id, $_POST);
        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    header("Location: ../index.php");
    die();
}