<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo print_r($_POST);

    try {
        require_once 'dbh.inc.php';
        require_once 'final_grade_model.inc.php';
        require_once 'final_grade_contr.inc.php';
        require_once 'login_model.inc.php';
        require_once 'config_session.inc.php';
        // add error handling
        
        if (isset($_POST["final-grade-submit"])) {
            echo "Final grade calculation initiated.";
            $current_grade = round($_POST["current-grade"]);
            $final_weight = round($_POST["final-weight"]);
            $desired_grade = round($_POST["desired-grade"]);

            $final_grade = calculate_final_grade($current_grade, $final_weight, $desired_grade);
            echo "Final grade calculated: $final_grade";

            $user_id = $_SESSION["user_id"];

            $results_final_grade = get_final_grade($pdo, $user_id);

            if ($results_final_grade) {
                echo "Final grade already exists for user.";
                update_final_grade($pdo, $user_id, $current_grade, $final_weight, $desired_grade, $final_grade);
            } else {
                echo "Final grade does not exist for user.";
                create_final_grade($pdo, $user_id, $current_grade, $final_weight, $desired_grade, $final_grade);
            }
        }
        else if (isset($_POST["advanced-final-grade-submit"])) {
            echo "Advanced final grade calculation initiated.";
            $row_count = 10;
            $row_data = $_POST;
            for ($i = 0; $i <= $row_count; $i++) {
                $row_data["weight$i"] = round(floatval($row_data["weight$i"]), 2);
                $row_data["grade$i"] = round(floatval($row_data["grade$i"]), 2);
            }
            $current_grade = calculate_all_rows_grades($row_count, $row_data);
            echo "Current grade calculated: $current_grade";

            $final_weight = round($_POST["final-weight"]);
            $desired_grade = round($_POST["desired-grade"]);

            $final_grade = calculate_final_grade($current_grade, $final_weight, $desired_grade);
            echo "Final grade calculated: $final_grade";

            $user_id = $_SESSION["user_id"];

            $results_final_grade_advanced = get_final_grade_advanced($pdo, $user_id);

            if ($results_final_grade_advanced) {
                echo "Advanced final grade already exists for user.";
                update_final_grade_advanced($pdo, $user_id, $current_grade, $final_weight, $desired_grade, $final_grade);
            } else {
                echo "Advanced final grade does not exist for user.";
                create_final_grade_advanced($pdo, $user_id, $current_grade, $final_weight, $desired_grade, $final_grade);
            }
            
            $results_fgai = $results_final_grade_advanced["id"];

            $results_final_grade_advanced_rows = get_final_grade_advanced_rows($pdo, $results_fgai);

            if ($results_final_grade_advanced_rows) {
                echo "Advanced final grade rows already exist for user.";
                delete_final_grade_advanced_rows($pdo, $results_fgai);
            }

            for ($i = 0; $i <= $row_count; $i++) {
                if (empty($row_data["weight$i"]) or empty($row_data["grade$i"])) {
                    continue;
                }
                create_final_grade_advanced_row($pdo, $results_fgai, $row_data["category$i"], $row_data["weight$i"], $row_data["grade$i"]);
            }
        }

        header("Location: ../home.php");

    } catch (Exception $e) {
        echo $e->getMessage();
    }

} else {
    header("Location: ../home.php");
    die();
}