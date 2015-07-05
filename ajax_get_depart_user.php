<?php
require_once("libraries/head.php");
require_once("libraries/class.FastTemplate.php");

if (!isLogin())
    exit;

if (isset($_POST["departid"])) {
    if (!isValidID($_POST["departid"]))
        exit;
    displayDepartUser($_POST["departid"], $_SESSION["userID"]);
}

function displayDepartUser($departID, $userID) {
    $tpl = new FastTemplate("templates/");
    $tpl->define(array("user" => "index/user.html",
                       "department" => "index/department.html",
                       "depart_user" => "index/depart_user.html",
                       "header" => "index/header.html"));
    $departDAO = new DepartmentDAO();
    $depart = $departDAO->getDepartmentByID($departID);
    if ($departID == "1" || $depart === null) {
        $tpl->assign("INDEX_DEPART_USER_HEADER", "");
    } else {
        $tpl->assign("INDEX_HEADER_NAME", $depart->getDepartmentName());
        $tpl->parse("INDEX_DEPART_USER_HEADER", "header");
    }
    
    $result = findDepartAndUser($departID, $userID);
    if ($result === false || count($result) === 0)
        $tpl->assign("INDEX_DEPART_USER", "");
    else {
        foreach($result as $node) {
            if ($node["type"] == 1) {
                $tpl->assign("INDEX_DEPARTID", $node["id"]);
                $tpl->assign("INDEX_DEPART_NAME", $node["name"]);
                $tpl->parse("INDEX_DEPART_USER", ".department");
            } elseif ($node["type"] == 2) {
                $tpl->assign("INDEX_USERID", $node["id"]);
                $tpl->assign("INDEX_USER_NAME", $node["name"]);
                $tpl->parse("INDEX_DEPART_USER", ".user");
            }
        }
    }
    $tpl->parse("MAIN", "depart_user");
    $tpl->FastPrint();
}

?>