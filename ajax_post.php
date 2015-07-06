<?php
require_once("libraries/head.php");

if (!isLogin())
    sendAjaxRedirect("login.php");

if (isset($_POST["groupid"]) && 
    isset($_POST["messagetype"]) && 
    isset($_POST["content"])) {
    $result = postRecord(
        $_SESSION["userID"], 
        $_POST["groupid"], 
        $_POST["messagetype"], 
        $_POST["content"]);
    if ($result === true)
        sendAjaxResSuc();
    else
        sendAjaxResErr($result);
}

function postRecord($userID, $groupID, $messageType, $content) {
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    
    if ($user->getRole()->getRoleID() == "4")
        return "This user was forbidden to post!";
    
    if (!isValidID($groupID))
        return "Group id is not valid!";
    if (!isValidMessageType($messageType))
        return "Message type is not valid!";
    if (gettype($content) != "string" || strlen($content) > 1000)
        return "Wrong type content or exceed max length(1000)!";
    
    
    $groupDAO = new GroupDAO();
    $group = $groupDAO->getGroupByID($groupID);
    if ($group === null)
        return "Can not find this group!";
    if ($group->getActivateStatus() === "2")
        return "Group is not activated!";
    
    $groupMemberDAO = new GroupMemberDAO();
    $groupMember = $groupMemberDAO->getGroupMember($group, $user);
    if ($groupMember === null)
        return "User didn't belong to this group!";
    $record = new Record(
        $group,
        $user,
        $messageType, 
        $content, 
        "1"
    );
    $recordDAO = new RecordDAO();
    $recordDAO->insertRecord($record);
    return true;
}

function isValidMessage($messageType) {
    if ($messageType === "1" ||
        $messageType === "2" ||
        $messageType === "3" ||
        $messageType === "4")
        return true;
    else
        return false;
}
?>