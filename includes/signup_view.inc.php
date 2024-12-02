<?php
declare(strict_types=1);


function check_signup_errors()
{
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        unset($_SESSION['errors_signup']);

        foreach ($errors as $error) {
            echo '<p class="w3-text-red w3-center w3-padding">' . $error . '</p>';
        }

    } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo '<br>';
        echo '<p class="w3-text-green w3-center w3-padding">Signup successful!</p>';
    }
}