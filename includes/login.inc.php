<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login_username = trim($_POST["username"]);
    $login_password = trim($_POST["password"]);

    echo "Login attempt initiated for username: $login_username";

    try {
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';
        require_once 'manualHashing.inc.php';

        $errors = [];

        if (is_input_empty($login_username, $login_password)) {
            $errors["empty_input"] = "Fill in all fields.";
            echo "Validation Error: Empty input detected for username: $login_username";
        }

        $result = get_user($pdo, $login_username);
        echo "Retrieved user data for username: $login_username";

        if (is_username_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
            echo "Validation Error: Incorrect username - $login_username";
        }

        if (!is_username_wrong($result) && !verifyHash($login_password, $result["salt"], $result["passw"])) {
            $errors["login_incorrect"] = "Incorrect login info!";
            echo "Validation Error: Incorrect password for username: $login_username";
        }

        echo "Validation complete for username: $login_username";

        require_once 'config_session.inc.php';
        echo "Session configuration included for username: $login_username";

        if (!empty($errors)) {
            $_SESSION["errors_login"] = $errors;
            $_SESSION["login_data"] = [
                "username" => htmlspecialchars($login_username)
            ];
            echo "Login failed for username: $login_username due to validation errors.";
            header("Location: ../login.php");
            die();
        }

        $newSessionId = session_create_id();
        $sessionID = $newSessionId . "_" . $result["id"];
        session_id($sessionID);
        session_start();

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["username"] = htmlspecialchars($result["username"]);
        $_SESSION["admin"] = $result["admin"];
        $_SESSION["last_regeneration"] = time();

        echo "User logged in successfully: $login_username with session ID: $sessionID";

        header("Location: ../home.php?login=success");

        $pdo = null;
        $stmt = null;

        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    } catch (Exception $e) {
        die("Exception: " . $e->getMessage());
    }
} else {
    echo "Invalid request method accessed: " . $_SERVER["REQUEST_METHOD"];
    header("Location: ../index.php");
    die();
}