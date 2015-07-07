<?php
require_once("libraries/head.php");

if (!isLogin())
    sendAjaxRedirect("login.php");

if (isset($_POST["groupid"]) && isset($_POST["adduserid"])) {
    $result = execAddToGroup($_SESSION["userID"], $_POST["groupid"], $_POST["adduserid"]);
    if ($result === true)
        sendAjaxResSuc();
    else
        sendAjaxResErr($result);  
} else
    sendAjaxResErr("Didn't choose group member!");

function execAddToGroup($userID, $groupID, $adduserIDs) {
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    
    if (!isValidID($groupID))
        return "Invalid group ID!";
    
    if (gettype($adduserIDs) != "array")
        return "Wrong type of user id!";
    if (count($adduserIDs) === 0)
        return "You have to choose users to add to this group!";
    
    foreach ($adduserIDs as $adduserID) {
        if (!isValidID($adduserID))
        return "Invalid user ID!";
    }
    
    $groupDAO = new GroupDAO();
    $group = $groupDAO->getGroupByID($groupID);
    
    if ($group === null)
        return "Group doesn't exist!";
    
    if ($group->getOwner()->getUserID() !== $userID)
        return "You are not the owner of this group!";
    
    $gmDAO = new GroupMemberDAO();
    
    
    foreach ($adduserIDs as $auID) {
        $aduser = $userDAO->getUserByID($auID);
        if ($aduser === null)
            continue;
        $gm = $gmDAO->getGroupMember($group, $aduser);
        if ($gm !== null)
            continue;
        $gm = new GroupMember(
            $group,
            $aduser,
            "2"
        );
        $gmDAO->insertGroupMember($gm);
    }
    
    return true;
}

?>