<?php
require_once("libraries/head.php");
require_once("libraries/class.FastTemplate.php");

displaySignup();

function displaySignup() {
    $tpl = new FastTemplate("templates/");
    $tpl->define(array("web_main" => "web_main.html",
                       "web_header" => "web_header.html",
                       "head_script" => "signup/head_script.html",
                       "body" => "signup/body.html",
                       "web_footer" => "web_footer.html"));
    
    $tpl->assign("TITLE", "Sign Up");
    $tpl->parse("WEB_HEADER", "web_header");
    $tpl->parse("HEAD_SCRIPT", "head_script");
    $tpl->parse("BODY", ".body");
    $tpl->parse("WEB_FOOTER", "web_footer");
    $tpl->parse("MAIN", "web_main");
    $tpl->FastPrint();
}
?>