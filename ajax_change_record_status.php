<?php
require_once("libraries/head.php");

if (!isLogin())
    sendAjaxRedirect("login.php");

if (isset($_POST["recordid"]) && isset($_POST["newrecordstatus"])) {
    if (!isValidID($_POST["recordid"]) || !isValidID($_POST["newrecordstatus"]))
        sendAjaxResErr("Record ID or Status invalid!");
    $result = executeChange($_SESSION["userID"], $_POST["recordid"], $_POST["newrecordstatus"]);
    if ($result === true)
        sendAjaxResSuc("Change record status successfully!");
    else
        sendAjaxResErr($result);
}

function executeChange($userID, $recordID, $newRecordStatus) {
    if ($newRecordStatus !== "1" && $newRecordStatus !== "2" && $newRecordStatus !== "3")
        return "Invalid status!";
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    
    $recordDAO = new RecordDAO();
    $record = $recordDAO->getRecordByID($recordID);
    if ($record === null)
        return "Could not find this record!";
    if ($record->getDisplayStatus() === $newRecordStatus)
        return "Old status is equal to new status, don't need to change!";
    if ($user->getRole()->getRoleID() === "3") {
        if ($record->getUser()->getUserID() !== $userID)
            return "You have no right to change group status!";
        if ($newStatus === "3")
            return "You have no right to delete this record!";
    }
    
    if ($newRecordStatus !== "3") {
        $record->setDisplayStatus($newRecordStatus);
        $recordDAO->updateRecord($record); // Do not have updateRecord function
    } else {
		$recordDAO->deleteRecord($record); //Do not have this function
		
    }
    return true;
}

?>
