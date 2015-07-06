<?php
require_once("libraries/head.php");

if (!isLogin())
    sendAjaxRedirect("login.php");

if (isset($_POST["groupmember"]) && isset($_POST["groupname"])) {
    $result = execCreateGroup($_SESSION["userID"], $_POST["groupmember"], $_POST["groupname"]);
    if ($result === true)
        sendAjaxResSuc();
    else
        sendAjaxResErr($result);
} else
    sendAjaxResErr("Didn't choose group member or input group name!");

function execCreateGroup($userID, $groupMember, $groupName) {
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    if ($user->getRole()->getRoleID() == "4")
        return "This user was forbidden to do this!";
    
    
    
    if (gettype($groupMember) != "array")
        return "Wrong type of group member!";
    if (count($groupMember) === 0)
        return "You must choose at least one group member!";
    if (count(array_unique($groupMember)) < count($groupMember))
        return "Group member has duplicate value!";
    if (in_array($userID, $groupMember))
        return "Group owner should not be a group member!";
    if ($groupName === "" || !isValidGroupName($groupName))
        return "Invalid group name, length should be between 2 to 20 and only accepts a-z, A-Z, single space!";
    
    $arr = array();
    foreach($groupMember as $groupUserID) {
        $groupUser = $userDAO->getUserByID($groupUserID);
        if ($groupUser === null)
            return "Could not find some group members!";
        $arr[] = $groupUser;
    }
    $newGroup = new Group($user, $groupName, "1");
    $groupDAO = new GroupDAO();
    $groupDAO->insertGroup($newGroup);
    
    $gmDAO = new GroupMemberDAO();
    $newGM = new GroupMember($newGroup, $user, "1");
    $gmDAO->insertGroupMember($newGM);
    
    foreach($arr as $gmUser) {
        $newGM = new GroupMember($newGroup, $gmUser, "2");
        $gmDAO->insertGroupMember($newGM);
    }
    
    return true;
}

function isValidGroupName($name) {
	if(strlen($name) < 2 || 
	   strlen($name) > 20 ||
	   preg_match('/[^A-Za-z0-9 ]/', $name) === 1)
	   return false;
	else
       return true;
}

?>