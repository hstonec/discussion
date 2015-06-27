<?php
session_set_cookie_params(300);
session_start();

function isLogin() {
    if (isset($_SESSION["userID"]))
        return true;
    else
        return false;
}
function login($userID) {
    $_SESSION["userID"] = $userID;
}
function logout() {
    unset($_SESSION["userID"]);
    session_destroy();
}
function forward($relPath) {
    if (gettype($relPath) != "string") {
        echo "ERROR: forward() only accepts String!";
        exit;
    }
    $appRootURL = "http://".$_SERVER["HTTP_HOST"];
    if ($_SERVER["SERVER_PORT"] !== "80")
        $appRootURL .= ":".$_SERVER["SERVER_PORT"];
    $appRootURL .= pathinfo($_SERVER["PHP_SELF"])["dirname"]."/";
    $newURL = $appRootURL.$relPath;
    header("Location: ".$newURL);
    exit;
}

?>