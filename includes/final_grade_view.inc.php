<?php
declare(strict_types=1);

function check_final_grade_errors() {
    if (isset($_SESSION["errors_final_grade"])) {
        $errors = $_SESSION["errors_final_grade"];
        
        echo "<br>";

        foreach($errors as $error) {
            echo '<p class="w3-text-red w3-center w3-padding">' . $error . '</p>';
        }
        $_SESSION['errors_final_grade'] = array();
    }
}

function check_final_grade_advanced_errors() {
    if (isset($_SESSION["errors_final_grade_advanced"])) {
        $errors = $_SESSION["errors_final_grade_advanced"];
        
        echo "<br>";

        foreach($errors as $error) {
            echo '<p class="w3-text-red w3-center w3-padding">' . $error . '</p>';
        }
        unset($_SESSION['errors_final_grade_advanced']);
    }
}

function display_final_grade($pdo, $user_id) {
    require_once 'final_grade_model.inc.php';

    try {
        $result = get_final_grade($pdo, $user_id);
        return $result;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function display_final_grade_advanced($pdo, $user_id) {
    require_once 'final_grade_model.inc.php';

    try {
        $result = get_final_grade_advanced($pdo, $user_id);
        return $result;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function display_final_grade_advanced_rows($pdo, $table_id) {
    require_once 'final_grade_model.inc.php';

    try {
        $result = get_final_grade_advanced_rows($pdo, $table_id);
        return $result;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}