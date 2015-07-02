<?php
require_once("libraries/head.php");

if (isLogin())
    sendAjaxRedirect("index.php");

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $result = execLogin($_POST["username"], $_POST["password"]);
    if ($result === true)
        sendAjaxResSuc("Login successfully!");
    else
        sendAjaxResErr($result);
}

function execLogin($username, $password) {
    $username = (string)$username;
    $password = (string)$password;
    if ($username == "" || $password == "")
        return "Username or password can not be empty!";
    if (!isValidUsername($username) || !isValidPassword($password))
        return "Username or password is invalid!";
    
    //encrypt password here!!!!!
    
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByUP($username, $password);
    if ($user === null)
        return "There is no user account matching the Username and Password provided.";
    login($user->getUserID());
    return true;
}
?>