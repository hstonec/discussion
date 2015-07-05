<?php
require_once("libraries/head.php");

if(!isLogin())
	sendAjaxRedirect("login.php");

if(isset($_POST["password"]) &&
   isset($_POST["newpassword"]) &&
   isset($_POST["confirmpw"])) {	
	   $result = execChangePW($_POST["password"],
						      $_POST["newpassword"],
							  $_POST["confirmpw"]);
		if ($result === true)
			sendAjaxResSuc("Change password successfully!");
		else
			sendAjaxResErr($result);
}
   
function execChangePW($password, $newpassword, $confirmpw) {
	if($password == "" || $newpassword == "" || $confirmpw == "")
		return "Please fill all the necessary information!";
	if(!isValidPassword($password) || !isValidPassword($newpassword))
		return "Please enter a valid password!";
	if($newpassword !== $confirmpw)
		return "The new password and the confirmed new password must be the same!";
	
	$userDAO = new UserDAO();
	
	$user = $userDAO->getUserByID($_SESSION["userID"]);
	
	if(!verifyPassword($password, $user->getPassword()))
		return "The old password you entered is not correct!";
	
	$encryptPW = encryptPassword($newpassword);
	
	$user->setPassword($encryptPW);
	$userDAO->updateUser($user);	
	return true;
}  

?>