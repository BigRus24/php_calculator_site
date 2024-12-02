<?php
declare(strict_types=1);

function get_final_grade($pdo, $user_id)
{
    $sql = "SELECT * FROM final_grade WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function create_final_grade($pdo, $user_id, $current_grade, $final_weight, $desired_grade, $final_grade) {
    $sql = "INSERT INTO final_grade (user_id, current_grade, final_weight, wanted_grade, final_grade) VALUES (:user_id, :current_grade, :final_weight, :wanted_grade, :final_grade)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'current_grade' => $current_grade, 'final_weight' => $final_weight, 'wanted_grade' => $desired_grade, 'final_grade' => $final_grade]);
}

function update_final_grade($pdo, $user_id, $current_grade, $final_weight, $desired_grade, $final_grade) {
    $sql = "UPDATE final_grade SET current_grade = :current_grade, final_weight = :final_weight, wanted_grade = :wanted_grade, final_grade = :final_grade WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'current_grade' => $current_grade, 'final_weight' => $final_weight, 'wanted_grade' => $desired_grade, 'final_grade' => $final_grade]);
}

function get_final_grade_advanced($pdo, $user_id)
{
    $sql = "SELECT * FROM final_grade_advanced WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function create_final_grade_advanced($pdo, $user_id, $current_grade, $final_weight, $desired_grade, $final_grade) {
    $sql = "INSERT INTO final_grade_advanced (user_id, current_grade, final_weight, wanted_grade, final_grade) VALUES (:user_id, :current_grade, :final_weight, :wanted_grade, :final_grade)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'current_grade' => $current_grade, 'final_weight' => $final_weight, 'wanted_grade' => $desired_grade, 'final_grade' => $final_grade]);
}

function update_final_grade_advanced($pdo, $user_id, $current_grade, $final_weight, $desired_grade, $final_grade) {
    $sql = "UPDATE final_grade_advanced SET current_grade = :current_grade, final_weight = :final_weight, wanted_grade = :wanted_grade, final_grade = :final_grade WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'current_grade' => $current_grade, 'final_weight' => $final_weight, 'wanted_grade' => $desired_grade, 'final_grade' => $final_grade]);
}

function get_final_grade_advanced_rows($pdo, $table_id)
{
    $sql = "SELECT * FROM final_grade_advanced_row WHERE table_id = :table_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['table_id' => $table_id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function create_final_grade_advanced_row($pdo, $table_id, $category, $weight, $grade) {
    $sql = "INSERT INTO final_grade_advanced_row (table_id, assignment_exam, weight, grade) VALUES (:table_id, :assignment_exam, :weight, :grade)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'table_id' => $table_id, 
        'assignment_exam' => $category, 
        'weight' => (float)$weight,
        'grade' => (float)$grade
    ]);
}

function delete_final_grade_advanced_rows($pdo, $table_id) {
    // problem SQLSTATE[01000]: Warning: 1265 Data truncated for column 'weight' at row 1
    $sql = "DELETE FROM final_grade_advanced_row WHERE table_id = :table_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['table_id' => $table_id]);
}