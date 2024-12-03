<?php
declare(strict_types=1);


function output_username() {
    if (isset($_SESSION["username"])) {
        echo $_SESSION["username"];
    }
}

function check_login_errors() {
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];
        
        echo "<br>";

        foreach($errors as $error) {
            echo '<p class="w3-text-red w3-center w3-padding">' . $error . '</p>';
        }
        unset($_SESSION['errors_login']);
    }
    else if (isset($_GET['login']) && $_GET['login'] === "success") {
        echo '<br>';
        echo '<p class="w3-text-green w3-center w3-padding">Login successful!</p>';
    }
}