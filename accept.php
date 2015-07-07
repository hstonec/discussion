<?php
require_once("libraries/head.php");

if (!isLogin())
    forward("login.php");

verify();

forward("index.php");

function verify() {
    if (isset($_GET["groupid"]) && isset($_GET["accept"])) {
        $groupID = $_GET["groupid"];
        if (!isValidID($groupID))
            return;
        $groupDAO = new GroupDAO();
        $group = $groupDAO->getGroupByID($groupID);
        if ($group === null)
            return;
        $userDAO = new UserDAO();
        $user = $userDAO->getUserByID($_SESSION["userID"]);
        $gmDAO = new GroupMemberDAO();
        $gm = $gmDAO->getGroupMember($group, $user);
        if ($gm === null)
            return;
        $status = $gm->getAcceptStatus();
        if ($status == "1")
            return;
        if ($_GET["accept"] == "1") {
            $gm->setAcceptStatus("1");
            $gmDAO->updateGroupMember($gm);
        } elseif ($_GET["accept"] == "3") {
            $gmDAO->deleteGroupMember($gm);
        }
    }
}

?>