<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/admin_view.inc.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">

    <div class="w3-container w3-padding-32 w3-center">
        <?php
            if (isset($_SESSION['username']) and $_SESSION['admin']) {
                echo '<p class="w3-text-blue">Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</p>';
            } else {
                header('Location: home.php');
                exit();
            }
        ?>
    </div>

    <!-- Table View -->
    <div class="w3-container w3-padding-32">
        <?php
            table_view();
        ?>
    </div>

</body>
</html>