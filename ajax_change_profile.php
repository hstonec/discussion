<?php
require_once("libraries/head.php");

if(!isLogin())
	sendAjaxRedirect("login.php");

if(isset($_POST["profile_firstname"]) &&
   isset($_POST["profile_lastname"]) &&
   isset($_POST["sex"])) {
	   
	   $result = execChangeProfile($_POST["profile_firstname"],
						      $_POST["profile_lastname"],
							  $_POST["sex"]);
		if ($result === true)
			sendAjaxResSuc("Change profile successfully!");
		else
			sendAjaxResErr($result);
}
   
function execChangeProfile($firstname, $lastname, $sex) {
	if(!isValidName($firstname) || !isValidName($lastname))
		return "Please enter valid names!";
	
	$userDAO = new UserDAO();
	$user = $userDAO->getUserByID($_SESSION["userID"]);
	
	if ($user->getFirstName() == $firstname && 
	    $user->getLastName() == $lastname &&
		$user->getGender() == $sex)
		return "No change for your profile!";
	
	if($user->getFirstName() != $firstname)
		$user->setFirstName($firstname);
	if($user->getLastName() != $lastname)
		$user->setLastName($lastname);
	if($user->getGender() != $sex)
		$user->setGender($sex);
	
	$userDAO->updateUser($user);	
	return true;
}  

?>