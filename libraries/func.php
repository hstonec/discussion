<?php
function isValidUsername($username) {
    if (strlen($username) < 6 ||
        strlen($username) > 20 ||
        preg_match("/[^A-Za-z0-9]/", $username) === 1)
        return false;
    else
        return true;
}
function isValidPassword($password) {
    if (strlen($password) < 6 ||
        strlen($password) > 20 ||
        preg_match('/[^A-Za-z0-9!@#$_]/', $password) === 1)
        return false;
    else
        return true;
}
?>