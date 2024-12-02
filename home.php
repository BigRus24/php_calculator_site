<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/final_grade_view.inc.php';
require_once 'includes/dbh.inc.php';

$final_grade_formdata = display_final_grade($pdo, $_SESSION["user_id"]);

$final_grade_advanced_formdata = display_final_grade_advanced($pdo, $_SESSION["user_id"]);

$final_grade_advanced_rows_formdata = display_final_grade_advanced_rows($pdo, $final_grade_advanced_formdata['id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">

    <div class="w3-container w3-padding-32 w3-center">
        <?php
            if (isset($_SESSION['username'])) {
                echo '<p class="w3-text-blue">Welcome, ' . $_SESSION['username'] . '!</p>';
            } else {
                header('Location: login.php');
                exit();
            }
        ?>
    </div>

    <!-- Logout Form -->
    <div class="w3-container w3-center w3-margin-top">
        <form action="includes/logout.inc.php" method="post">
            <button type="submit" class="w3-button w3-red w3-hover-light-red">Logout</button>
        </form>
    </div>

    <!-- Home Page Content -->
    <div class="w3-container w3-center w3-padding-32">
        <h1 class="w3-text-dark-grey">Welcome to the Home Page!</h1>
    </div>

    <!-- Navigation Links -->
    <div class="w3-container w3-center w3-margin-top">
        <a href="signup.php" class="w3-button w3-blue w3-hover-light-blue">Signup</a>
        <a href="login.php" class="w3-button w3-blue w3-hover-light-blue">Login</a>
    </div>

    <!-- Final Grade Calculator -->
    <div class="w3-container w3-padding-32 w3-center">
        <h2>Final Grade Calculator</h2>
        <p class="w3-text-grey">Enter your current grade, final weight, and desired grade to calculate your final grade.</p>
        <div class="w3-center">
            <?php
                check_final_grade_errors();
            ?>
        </div>
        <form action="includes/final_grade.inc.php" method="post" class="w3-container">
            <div class="w3-margin-bottom">
                <label for="current-grade" class="w3-label w3-text-grey">Current Grade:</label>
                <input type="number" step="any" name="current-grade" id="current-grade" class="w3-input w3-border" value="<?= htmlspecialchars($final_grade_formdata['current_grade'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="w3-margin-bottom">
                <label for="final-weight" class="w3-label w3-text-grey">Final Weight:</label>
                <input type="number" step="any" name="final-weight" id="final-weight" class="w3-input w3-border" value="<?= htmlspecialchars($final_grade_formdata['final_weight'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="w3-margin-bottom">
                <label for="desired-grade" class="w3-label w3-text-grey">Desired Grade:</label>
                <input type="number" step="any" name="desired-grade" id="desired-grade" class="w3-input w3-border" value="<?= htmlspecialchars($final_grade_formdata['wanted_grade'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div>
                <button type="submit" name="final-grade-submit" class="w3-button w3-blue w3-hover-light-blue">Calculate Final Grade</button>
            </div>
        </form>

        <div class="w3-center w3-margin-top">
            <?php
                if (isset($final_grade_formdata['final_grade'])) {
                    echo '<p class="w3-text-blue">Your final grade needs to be: ' . $final_grade_formdata['final_grade'] . '</p>';
                }
            ?>

    </div>

    <!-- Advanced Final Grade Calculator -->
    <div class="w3-container w3-padding-32 w3-center">
        <h2>Advanced Final Grade Calculator</h2>
        <p class="w3-text-grey">Enter up to 10 assignments or exams to calculate your final grade.</p>

        <div class="w3-center">
            <?php
                check_final_grade_advanced_errors();
            ?>
        </div>

        <form action="includes/final_grade.inc.php" method="post" class="w3-container">
            <table class="w3-table-all w3-bordered w3-hoverable w3-centered" style="width: 100%;">
                <tr>
                    <th>Assignment/Exam (optional)</th>
                    <th>Weight</th>
                    <th>Grade</th>
                </tr>
                <?php
                    for ($i = 0; $i < 11; $i++) {
                        if (!isset($final_grade_advanced_rows_formdata[$i])) {
                            $row = array("assignment_exam" => "", "weight" => "", "grade" => "");
                        } else {
                            $row = $final_grade_advanced_rows_formdata[$i];
                        }
                        echo '<tr>';
                        echo '<td><input type="text" name="category' . $i . '" class="w3-input w3-border" value="' . $row["assignment_exam"] .'"></td>';
                        echo '<td><input type="number" step="any" name="weight' . $i . '" class="w3-input w3-border" value="' . $row["weight"] .'"></td>';
                        echo '<td><input type="number" step="any" name="grade' . $i . '" class="w3-input w3-border" value="' . $row["grade"] .'"></td>';
                        echo '</tr>';
                    }
                ?>
            </table>
            <div class="w3-margin-bottom">
                <label for="final-weight" class="w3-label w3-text-grey">Final Weight:</label>
                <input type="number" step="any" name="final-weight" class="w3-input w3-border" value="<?= htmlspecialchars($final_grade_advanced_formdata['final_weight'], ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="w3-margin-bottom">
                <label for="desired-grade" class="w3-label w3-text-grey">Desired Grade:</label>
                <input type="number" step="any" name="desired-grade" class="w3-input w3-border" value="<?= htmlspecialchars($final_grade_advanced_formdata['wanted_grade'], ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="w3-margin-top">
                <button type="submit" name="advanced-final-grade-submit" class="w3-button w3-blue w3-hover-light-blue">Calculate Advanced Final Grade</button>
            </div>
        </form>

        <div class="w3-center w3-margin-top">
            <?php
                if (isset($final_grade_advanced_formdata['final_grade'])) {
                    echo '<P class="w3-text-blue">with an average grade of: ' . $final_grade_advanced_formdata['current_grade'] . '</p>';
                    echo '<p class="w3-text-blue">Your final grade needs to be: ' . $final_grade_advanced_formdata['final_grade'] . '</p>';
                }
            ?>
        </div>
    </div>

</body>
</html>
