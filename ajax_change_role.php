<?php
require_once("libraries/head.php");

if (!isLogin())
    sendAjaxRedirect("index.php");

if (isset($_POST["userid"]) && isset($_POST["newrole"])) {
    if (!isValidID($_POST["userid"]) || !isValidID($_POST["newrole"]))
        sendAjaxResErr("User or role status invalid!");
    $result = executeChange($_SESSION["userID"], $_POST["userid"], $_POST["newrole"]);
    if ($result === true)
        sendAjaxResSuc("Change role status successfully!");
    else
        sendAjaxResErr($result);
}

function executeChange($currUser, $userid, $newrole) {
    if ($newrole !== "1" && $newrole !== "2" && $newrole !== "3" && $newrole !== "4")
        return "Invalid status!";
    $userDAO = new UserDAO();
    $userChan = $userDAO->getUserByID($userid);
    
    $userCurr = $userDAO->getUserByID($currUser); //get current session user
    if ($userCurr->getRole()->getRoleID() !== "1" && $userCurr->getRole()->getRoleID() !== "2" )
        return "You have no right to change user status!";
    if ($userChan === null)                             //database 
        return "Could not find this user!";
    if ($userChan->getRole()->getRoleID() === $newrole)            //type
        return "Old status is equal to new status, don't need to change!";

    if ($userCurr->getRole()->getRoleID() === "2" ){
        if ($newrole === "1" || $newrole === "2")
            return "You have no right to set an advanced user.";
        }
    $roleDAO = new RoleDAO;
    $newroleObj = $roleDAO->getRoleByID($newrole);
    $userChan->setRole($newroleObj);
    $userDAO->updateUser($userChan);
    return true;
}
?>