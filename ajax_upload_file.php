<?php
require_once("libraries/head.php");

if (!isLogin())
    sendAjaxRedirect("login.php");

if (isset($_POST["groupid"]) && isset($_FILES["uploadfile"])) {
    $result = uploadFile($_SESSION["userID"], $_POST["groupid"], $_FILES["uploadfile"]);
    if ($result === true)
        sendAjaxResSuc();
    else
        sendAjaxResErr($result);
}

function uploadFile($userID, $groupID, $file) {
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    
    if ($user->getRole()->getRoleID() == "4")
        return "This user was forbidden to upload file!";
    
    if (!isValidID($groupID))
        return "Group id is not valid!";
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
    
    if (gettype($file["error"]) == "array")
        return "Only accept one file!";
    $res = isValidUploadFile($file["error"]);
    if ($res !== true)
        return $res;
    $fileType = -1;
    $res = isValidImage($file["name"]);
    if ($res === true)
        $fileType = "2";
    $res = isValidFile($file["name"]);
    if ($res === true)
        $fileType = "3";
    if ($fileType === -1)
        return "Only accepts jpeg/jpg/gif/png/zip file!";
    
    $record = new Record(
        $group,
        $user,
        $fileType, 
        "temp", 
        "1"
    );
    $recordDAO = new RecordDAO();
    $recordDAO->insertRecord($record);
    
    $fileDir = "upload/";
    $filePath = $fileDir.$record->getRecordID()."_".$file["name"];
    
    $record->setContent($filePath);
    $recordDAO->updateRecord($record);
    
    if (file_exists($filePath))
        unlink($filePath);
    if (!move_uploaded_file($file['tmp_name'], $filePath))
        return "Fail to move file, please contact administrator!";
    return true;
}

?>