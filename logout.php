<?php
require_once("libraries/head.php");
require_once("libraries/class.FastTemplate.php");


if (!isLogin())
    forward("login.php");

logout();

forward("login.php");

$tpl = new FastTemplate("templates/");
$tpl->define(array("main" => "logout/main.html"));    
$tpl->parse("MAIN", "main");
$tpl->FastPrint();
?>