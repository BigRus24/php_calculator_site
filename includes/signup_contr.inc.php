<?php
declare(strict_types=1);


function is_input_empty(string $signup_username, string $pwd, string $signup_email)
{
    if (empty($signup_username) || empty($pwd) || empty($signup_email)) {
        return true;
    }
    else {
        return false;
    }
}

function is_email_invalid(string $signup_email)
{
    if (!filter_var($signup_email, FILTER_VALIDATE_EMAIL))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function is_username_taken(object $pdo, string $signup_username)
{
    if (get_username($pdo, $signup_username)) {
        echo "Username taken <br>";
        return true;
    } else {
        echo "Username not taken <br>";
        return false;
    }
    return get_username($pdo, $signup_username);
}

function is_email_registered(object $pdo, string $signup_email)
{
    if (get_email($pdo, $signup_email)) {
        return true;
    } else {
        return false;
    }
}

function create_user(object $pdo, string $signup_username, string $signup_password, string $signup_email)
{
    echo "Inside create_user<br>";
    set_user($pdo, $signup_username, $signup_password, $signup_email);
}