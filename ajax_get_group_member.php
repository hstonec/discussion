<?php
require_once("libraries/head.php");
require_once("libraries/class.FastTemplate.php");

if (!isLogin())
    exit;

$tpl = new FastTemplate("templates/");
$tpl->define(array("group_checked_member" => "index/group_checked_member.html"));

if (isset($_POST["groupid"])) {
    $groupID = $_POST["groupid"];
    if (!isValidID($groupID))
        return;
    $userID = $_SESSION["userID"];
    $groupDAO = new GroupDAO();
    $group = $groupDAO->getGroupByID($groupID);
    if ($group === null)
        return;
    
    $gmDAO = new GroupMemberDAO();
    $gms = $gmDAO->getGroupMembersByGroup($group);
    
    foreach ($gms as $gm) {
        if ($gm->getUser()->getUserID() === $userID)
            continue;
        $tpl->assign("INDEX_GROUP_CHECKED_USERID", $gm->getUser()->getUserID());
        $tpl->assign("INDEX_GROUP_CHECKED_USERNAME", $gm->getUser()->getFirstName()." ".$gm->getUser()->getLastName());
        $tpl->parse("MAIN", ".group_checked_member");
    }
    $tpl->FastPrint();
}




?>