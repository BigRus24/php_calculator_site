<?php
declare(strict_types=1);

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