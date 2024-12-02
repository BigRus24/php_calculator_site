<?php
declare(strict_types=1);

function calculate_final_grade($current_grade, $final_weight, $desired_grade) {

    $final_weight_decimal = $final_weight / 100;

    $final_grade = ($desired_grade - ($current_grade * (1 - $final_weight_decimal))) / $final_weight_decimal;

    return round($final_grade, 2);
}

function calculate_all_rows_grades($row_count, $row_data) {
    // division by zero is not possible because the user has to input the weights
    $current_grade = floatval(0);
    $total_weight = floatval(0);
    for ($i = 0; $i <= $row_count; $i++) {
        $weight = $row_data["weight$i"];
        $grade = $row_data["grade$i"];
        $current_grade += $weight * $grade;
        $total_weight += $weight;
    }
    return round($current_grade / $total_weight, 2);
}