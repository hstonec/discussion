<?php
require_once("libraries/head.php");

if(!isLogin())
	sendAjaxRedirect("login.php");

if(isset($_POST["profile_firstname"]) &&
   isset($_POST["profile_lastname"]) &&
   isset($_POST["sex"]) &&
   isset($_POST["departmentid"])) {
	   
	   $result = execChangeProfile($_POST["profile_firstname"],
						      $_POST["profile_lastname"],
							  $_POST["sex"],
                              $_POST["departmentid"]);
		if ($result === true)
			sendAjaxResSuc("Change profile successfully!");
		else
			sendAjaxResErr($result);
}
   
function execChangeProfile($firstname, $lastname, $sex, $departmentID) {
	if(!isValidName($firstname) || !isValidName($lastname))
		return "Please enter valid names!";
	
    if(!isValidID($departmentID))
        return "Invalid department id!";
    
    $departDAO = new DepartmentDAO();
    $depart = $departDAO->getDepartmentByID($departmentID);
    if ($depart === null)
        return "Could not find the depart!";
    
    
    
	$userDAO = new UserDAO();
	$user = $userDAO->getUserByID($_SESSION["userID"]);
	
    $user->setDepartment($depart);

	if($user->getFirstName() != $firstname)
		$user->setFirstName($firstname);
	if($user->getLastName() != $lastname)
		$user->setLastName($lastname);
	if($user->getGender() != $sex)
		$user->setGender($sex);
	
    
    if (isset($_FILES["uploadphoto"])) {
        $ans = uploadPhoto($user, $_FILES["uploadphoto"]);
        if ($ans !== true)
            return $ans;
    }
        
	$userDAO->updateUser($user);	
	return true;
}

function uploadPhoto($user, $file) {

    if ($user->getRole()->getRoleID() == "4")
        return "This user was forbidden to do this!";
    
    
    if (gettype($file["error"]) == "array")
        return "Only accept one file!";
    $res = isValidUploadFile($file["error"]);
    if ($res !== true)
        return $res;
    
    $res = isValidImage($file["name"]);
    if ($res !== true)
        return $res;
    
    $fileDir = "photo/";
    $filePath = $fileDir.$user->getUserID().".".pathinfo($file["name"], PATHINFO_EXTENSION);
    
    
    if (file_exists($filePath))
        unlink($filePath);
    if (!move_uploaded_file($file['tmp_name'], $filePath))
        return "Fail to move file, please contact administrator!";
   
    $user->setPhotoURL($filePath);
    return true;
}

?>