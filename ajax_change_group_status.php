<?php
require_once("libraries/head.php");

if (!isLogin())
    sendAjaxRedirect("index.php");

if (isset($_POST["groupid"]) && isset($_POST["newstatus"])) {
    if (!isValidID($_POST["groupid"]) || !isValidID($_POST["newstatus"]))
        sendAjaxResErr("Group ID or Status invalid!");
    $result = executeChange($_SESSION["userID"], $_POST["groupid"], $_POST["newstatus"]);
    if ($result === true)
        sendAjaxResSuc("Change group status successfully!");
    else
        sendAjaxResErr($result);
}

function executeChange($userID, $groupID, $newStatus) {
    $newStatus = $newStatus;
    if ($newStatus !== "1" && $newStatus !== "2" && $newStatus !== "3")
        return "Invalid status!";
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    
    $groupDAO = new GroupDAO();
    $group = $groupDAO->getGroupByID($groupID);
    if ($group === null)
        return "Could not find this group!";
    if ($group->getActivateStatus() === $newStatus)
        return "Old status is equal to new status, don't need to change!";
    if ($user->getRole()->getRoleID() === "3") {
        if ($group->getOwner()->getUserID() !== $userID)
            return "You have no right to change group status!";
        if ($newStatus === "3")
            return "You have no right to delete this group!";
    }
    
    if ($newStatus !== "3") {
        $group->setActivateStatus($newStatus);
        $groupDAO->updateGroup($group);
    } else {
        //delete records
        $recordDAO = new RecordDAO();
        $recordDAO->deleteRecordsByGroup($group);
        //delete groupmember
        $gmDAO = new GroupMemberDAO();
        $gmDAO->deleteGroupMembersByGroup($group);
        //delete group
        $groupDAO->deleteGroup($group);
    }
    return true;
}
?>