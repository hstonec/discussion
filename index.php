<?php
require_once("libraries/head.php");

if (!isLogin())
    forward("login.php");

displayIndex();

function displayIndex() {
    $tpl = new FastTemplate("templates/");
    $tpl->define(array("main" => "index/main.html"));
    
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($_SESSION["userID"]);
    $tpl->assign("INDEX_FIRST", $user->getFirstName());
    
    $tpl->parse("MAIN", "main");
    $tpl->FastPrint();
    
}

function getDepartments() {
    $deptDAO = new DepartmentDAO();
    
}

?>