<?php
declare(strict_types=1);


function is_input_empty(string $login_username, string $login_password) {
    if (empty($login_username) || empty($login_password)) {
        return true;
    }
    else {
        return false;
    }
}
function is_username_wrong( $result) {
    if ($result == false) {
        return true;
    } else {
        return false;
    }
}

function is_password_wrong(string $login_password, string $hashedPwd) {
    if (!password_verify($login_password, $hashedPwd)) {
        return true;
    } else {
        return false;
    }
}