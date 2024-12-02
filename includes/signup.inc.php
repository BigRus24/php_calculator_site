<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $signup_username = trim($_POST["username"]);
    $signup_password = trim($_POST["password"]);
    $signup_email = trim($_POST["email"]);

    echo "Signup attempt initiated for username: $signup_username and email: $signup_email";

    try {
        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';
        require_once 'config_session.inc.php';

        $errors = [];

        echo $signup_username;

        if (is_input_empty($signup_username, $signup_password, $signup_email)) {
            $errors["empty_input"] = "Please fill in all fields.";
            echo "Validation Error: Empty input detected.";
        }

        if (is_email_invalid($signup_email)) {
            $errors["invalid_email"] = "Please enter a valid email address.";
            echo "Validation Error: Invalid email format - $signup_email";
        }

        if (is_username_taken($pdo, $signup_username)) {
            $errors["username_taken"] = "This username is already taken.";
            echo "Validation Error: Username already taken - $signup_username";
        }

        if (is_email_registered($pdo, $signup_email)) {
            $errors["email_used"] = "This email is already registered.";
            echo "Validation Error: Email already registered - $signup_email";
        }

        if (!empty($errors)) {
            $_SESSION["errors_signup"] = $errors;
            $_SESSION["signup_data"] = [
                "username" => htmlspecialchars($signup_username),
                "email" => htmlspecialchars($signup_email)
            ];
            echo "Signup failed due to validation errors.";
            header("Location: ../signup.php");
            die();
        }
        echo $signup_username;
        create_user($pdo, $signup_username, $signup_password, $signup_email);
        echo "User successfully registered: $signup_username";

        $_SESSION["signup_success"] = "Signup successful! You can now log in.";
        header("Location: ../home.php?signup=success");

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