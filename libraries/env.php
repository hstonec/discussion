<?php
session_set_cookie_params(1000);
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
    
    $baseURL = pathinfo($_SERVER["PHP_SELF"])["dirname"];
    while (true) {
        if (strpos($relPath, "./") === 0)
            $relPath = substr($relPath, 2);
        elseif (strpos($relPath, "../") === 0) {
            $baseURL = pathinfo($baseURL)["dirname"];
            $relPath = substr($relPath, 3);
        } elseif (strpos($relPath, "/") === 0) {
            echo "ERROR: forward() only accepts relative path!";
            exit;
        } else
            break;
    }
    
    $appRootURL = "http://".$_SERVER["HTTP_HOST"];
    if ($_SERVER["SERVER_PORT"] !== "80")
        $appRootURL .= ":".$_SERVER["SERVER_PORT"];
    
    $newURL = $appRootURL.$baseURL."/".$relPath;
    header("Location: ".$newURL);
    exit;
}
function sendAjaxRes($jsonArray) {
    if (gettype($jsonArray) != "array" || count($jsonArray) === 0) {
        echo "ERROR: Argument of sendAjaxRes() isn't an Array or is empty!";
        exit;
    }
    if (!isset($jsonArray["success"]) || !isset($jsonArray["message"])) {
        echo "ERROR: \$jsonArray should contain \"success\" and \"message\"!";
        exit;
    }
    header("Content-type: application/json");
    echo json_encode($jsonArray);
    exit;
}
function sendAjaxResSuc($jsonArray, $message = null) {
    if ($message === null) {
        $message = $jsonArray;
        $jsonArray = array();
    }
    $jsonArray["success"] = true;
    $jsonArray["message"] = $message;
    sendAjaxRes($jsonArray);
}
function sendAjaxResErr($jsonArray, $message = null) {
    if ($message === null) {
        $message = $jsonArray;
        $jsonArray = array();
    }
    $jsonArray["success"] = false;
    $jsonArray["message"] = $message;
    sendAjaxRes($jsonArray);
}
function sendAjaxRedirect($url) {
    header("Content-type: application/json");
    $res = array("url" => $url);
    echo json_encode($res);
    exit;
}
?>