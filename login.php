<?php
require_once("libraries/head.php");
require_once("libraries/class.FastTemplate.php");


if (isLogin())
    forward("index.php");

if (isset($_GET["info"]) && $_GET["info"] == "signup") {
    displayLogin("You can login with your Username and Password!");
} else if (isset($_GET["info"]) && $_GET["info"] == "logout")
    displayLogin("You have loged out!");
else
    displayLogin();


function displayLogin($message = null) {
    $tpl = new FastTemplate("templates/");
    $tpl->define(array("web_main" => "web_main.html",
                       "web_header" => "web_header.html",
                       "head_script" => "login/head_script.html",
                       "message" => "login/message.html",
                       "body" => "login/body.html",
                       "web_footer" => "web_footer.html"));
    
    if ($message != null) {
        $tpl->assign("LOGIN_MESSAGE", $message);
        $tpl->parse("LOGIN_INFO", "message");
    } else
        $tpl->assign("LOGIN_INFO", "");
    
    $tpl->assign("TITLE", "Login");
    $tpl->parse("WEB_HEADER", "web_header");
    $tpl->parse("HEAD_SCRIPT", "head_script");
    $tpl->parse("BODY", ".body");
    $tpl->parse("WEB_FOOTER", "web_footer");
    $tpl->parse("MAIN", "web_main");
    $tpl->FastPrint();
}

?>