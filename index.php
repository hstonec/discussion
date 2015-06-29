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

function postRecord($userID, $groupID, $messageType, $content) {
    if (!isValidID($groupID))
        return "Group id is not valid!";
    if (!isValidMessage($messageType, $content))
        return "Message is not valid!";
    $groupDAO = new GroupDAO();
    $group = $groupDAO->getGroupByID($groupID);
    if ($group === null)
        return "Can not find this group!";
    
}

function isValidMessage($messageType, $content) {
    //1 text
    //2 link
    //3 img
    //4 file
    return true;
}

function isGroupActivate($group) {
    
}

function getDepartments() {
    $deptDAO = new DepartmentDAO();
    $root = $deptDAO->getDepartmentByID(0);
    return getDeptTree($root, $deptDAO);
}
function getDeptTree($root, $deptDAO) {
    $arr = array("id" => $root->getDepartmentID(),
                 "name" => $root->getDepartmentName());
    $child = $deptDAO->getChildDepartments($root);
    if ($child === null)
        $arr["child"] = false; 
    else {
        $arr["child"] = array();
        foreach ($child as $childDept)
            $arr["child"][] = getDeptTree($root, $deptDAO);
    }
    return $child;
}
?>