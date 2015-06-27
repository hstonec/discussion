<?php
require_once("libraries/head.php");

if (!isLogin())
    forward("login.php");

$userDAO = new UserDAO();
$user = $userDAO->getUserByID($_SESSION["userID"]);

echo "Welcome, ".$user->getFirstName();
?>