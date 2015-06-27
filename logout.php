<?php
require_once("libraries/head.php");

if (!isLogin())
    forward("login.php");

logout();

$tpl = new FastTemplate("templates/");
$tpl->define(array("main" => "logout/main.html"));    
$tpl->parse("MAIN", "main");
$tpl->FastPrint();
?>