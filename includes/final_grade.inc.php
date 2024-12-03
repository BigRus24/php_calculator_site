<?php
session_start();

class Handle_this extends Exception {}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo print_r($_POST);

    try {
        require_once 'dbh.inc.php';
        require_once 'final_grade_model.inc.php';
        require_once 'final_grade_contr.inc.php';
        require_once 'login_model.inc.php';
        require_once 'config_session.inc.php';
        
        $final_grade_errors = [];
        $final_grade_advanced_errors = [];

        if (isset($_POST["final-grade-submit"])) {
            echo "Final grade calculation initiated.";
            $current_grade = round($_POST["current-grade"]);
            $final_weight = round($_POST["final-weight"]);
            $desired_grade = round($_POST["desired-grade"]);

            if ($current_grade < 0 or $current_grade > 100 or $final_weight < 0 or $final_weight > 100 or $desired_grade < 0 or $desired_grade > 100) {
                $final_grade_errors["invalid_input"] = "Invalid input detected.";
                throw new Handle_this("Invalid input detected.");
            }

            if (empty($current_grade) or empty($final_weight) or empty($desired_grade)) {
                $final_grade_errors["empty_input"] = "Fill in all fields.";
                throw new Handle_this("Fill in all fields.");
            }

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

                if ($row_data["weight$i"] < 0 or $row_data["weight$i"] > 100 or $row_data["grade$i"] < 0 or $row_data["grade$i"] > 100) {
                    $final_grade_errors["invalid_input"] = "Invalid input detected in row $i.";
                    echo "Validation Error: Invalid input detected.";
                    throw new Handle_this("Invalid input detected.");
                }

                if ((!empty($row_data["weight$i"]) or !empty($row_data["grade$i"]))) {
                    $final_grade_errors["empty_input"] = "Fill in all fields.";
                    echo "Validation Error: Empty input detected in row $i.";
                    throw new Handle_this("Fill in all fields.");
                }
            }
            $current_grade = calculate_all_rows_grades($row_count, $row_data);
            echo "Current grade calculated: $current_grade";

            $final_weight = round($_POST["final-weight"]);
            $desired_grade = round($_POST["desired-grade"]);

            if ($final_weight < 0 or $final_weight > 100 or $desired_grade < 0 or $desired_grade > 100) {
                $final_grade_advanced_errors["invalid_input"] = "Invalid input detected.";
                echo "Validation Error: Invalid input detected.";
                throw new Handle_this("Invalid input detected.");
            }

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

    } catch (Handle_this $e) {
        if (!empty($final_grade_errors) or !empty($final_grade_advanced_errors)) {
            echo "Final grade calculation failed due to validation errors.";
            $_SESSION["errors_final_grade"] = $final_grade_errors;
            $_SESSION["erros_final_grade_advanced"] = $final_grade_advanced_errors;
            header("Location: ../home.php");
            die();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }

} else {
    header("Location: ../home.php");
    die();
}