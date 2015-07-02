<?php
require_once("libraries/head.php");
require_once("libraries/class.FastTemplate.php");


if (isLogin())
    forward("index.php");

displayLogin();

function displayLogin() {
    $tpl = new FastTemplate("templates/");
    $tpl->define(array("web_main" => "web_main.html",
                       "web_header" => "web_header.html",
                       "head_script" => "login/head_script.html",
                       "body" => "login/body.html",
                       "web_footer" => "web_footer.html"));
    
    $tpl->assign("TITLE", "Login");
    $tpl->parse("WEB_HEADER", "web_header");
    $tpl->parse("HEAD_SCRIPT", "head_script");
    $tpl->parse("BODY", ".body");
    $tpl->parse("WEB_FOOTER", "web_footer");
    $tpl->parse("MAIN", "web_main");
    $tpl->FastPrint();
}

?>