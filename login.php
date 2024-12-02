<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/login_view.inc.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">

    <div class="w3-container w3-padding-32 w3-center">
        <h2>Login</h2>
    </div>

    <div class="w3-container w3-card-4 w3-white w3-padding-32 w3-margin-top w3-round w3-center" style="max-width: 400px; margin: auto;">
        <form action="includes/login.inc.php" method="post" class="w3-container">
            <div class="w3-margin-bottom">
                <label for="username" class="w3-label w3-text-grey">Username:</label>
                <input type="text" name="username" id="username" class="w3-input w3-border" required>
            </div>
            <div class="w3-margin-bottom">
                <label for="password" class="w3-label w3-text-grey">Password:</label>
                <input type="password" name="password" id="password" class="w3-input w3-border" required>
            </div>
            <div>
                <input type="submit" value="Login" class="w3-button w3-block w3-blue w3-hover-light-blue">
            </div>
        </form>
    </div>

    <div class="w3-container w3-center w3-margin-top">
        <?php
            check_login_errors();
        ?>
    </div>

</body>
</html>