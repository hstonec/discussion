<?php
require_once("libraries/head.php");

if (!isLogin())
    sendAjaxRedirect("login.php");

if (isset($_POST["groupid"])) {
    
    
    if (isset($_POST["checkedbox"]))
        $checkedUser = $_POST["checkedbox"];
    else
        $checkedUser = array();
    $result = execEditGroup($_SESSION["userID"], $_POST["groupid"], $checkedUser);
    if ($result === true)
        sendAjaxResSuc();
    else
        sendAjaxResErr($result);  
} else
    sendAjaxResErr("Didn't choose group!");


function execEditGroup($userID, $groupID, $checkedUser) {
    
    if (gettype($checkedUser) != "array")
        return "Wrong type of group member!";
    
    $checkedUser[] = $userID;
    
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    
    if (!isValidID($groupID))
        return "Invalid group ID!";
    
    $groupDAO = new GroupDAO();
    $group = $groupDAO->getGroupByID($groupID);
    if ($group === null)
        return "Group doesn't exist!";
    
    if ($group->getOwner()->getUserID() !== $userID)
        return "You are not the owner of this group!";
    
    $gmDAO = new GroupMemberDAO();
    $gms = $gmDAO->getGroupMembersByGroup($group);
    
    foreach ($gms as $gm) {
        $alreadyUser = $gm->getUser();
        if (in_array($alreadyUser->getUserID(), $checkedUser))
            continue;
        $gmDAO->deleteGroupMember($gm);
    }
    
    return true;
}

?>