<?php

function isValidUsername($username) {
    if (strlen($username) < 6 ||
        strlen($username) > 20 ||
        preg_match("/[^A-Za-z0-9]/", $username) === 1)
        return false;
    else
        return true;
}
function isValidPassword($password) {
    if (strlen($password) < 6 ||
        strlen($password) > 20 ||
        preg_match('/[^A-Za-z0-9!@#$_]/', $password) === 1)
        return false;
    else
        return true;
}
function isValidID($id) {
	if (preg_match('/^(0|[1-9][0-9]*)$/', $id) === 1)
        return true;
    else
        return false;
}
function isValidName($name) {
	if(strlen($name) < 2 || 
	   strlen($name) > 20 ||
	   preg_match('/[^A-Za-z\']/', $name) === 1)
	   return false;
	else
		return true;
}
function isValidGender($gender) {
    if ($gender === "1" || $gender === "2")
        return true;
    else
        return false;
}
function isValidUploadFile($error) {
    if ($error === 0)
        return true;
    else if ($error === 1)
        return "The uploaded file exceeds the upload_max_filesize.";
    else if ($error === 2)
        return "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
    else if ($error === 3)
        return "The uploaded file was only partially uploaded.";
    else if ($error === 4)
        return "No file was uploaded.";
    else
        return "Unknown error, code: ".$error;
}
function isValidImage($filename) {
    $validExt = array("jpg", "jpeg", "gif", "png");
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if (in_array($ext, $validExt))
        return true;
    else
        return "Unsupported file format, photo must be a jpeg/jpg/gif/png!";
}
function isValidFile($filename) {
    $validExt = array("zip");
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if (in_array($ext, $validExt))
        return true;
    else
        return "Unsupported file format, file must be a zip!";
}


function encryptPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

function findDepartAndUser($departID, $userID) {
    $departDAO = new DepartmentDAO();
    $depart = $departDAO->getDepartmentByID($departID);
    if ($depart === null)
        return false;
    $result = array();
    $subDepart = $departDAO->getChildDepartments($depart);
    if ($subDepart !== null) {
        foreach($subDepart as $subDep) {
            if ($subDep->getDepartmentID() === $subDep->getParentID())
                continue;
            $node = array();
            $node["type"] = 1;
            $node["id"] = $subDep->getDepartmentID();
            $node["name"] = $subDep->getDepartmentName();
            $result[] = $node;
        }
    }
    $userDAO = new UserDAO();
    $users = $userDAO->getUsersByDepartment($depart);
    if ($users !== null) {
        foreach($users as $user) {
            if ($user->getUserID() == $userID)
                continue;
            $node = array();
            $node["type"] = 2;
            $node["id"] = $user->getUserID();
            $node["name"] = $user->getFirstName()." ".$user->getLastName();
            $result[] = $node;
        }
    }
    return $result;
}


function changeUserRole($adminID, $userID, $roleID) {
	$userDAO = new UserDAO();
	$roleDAO = new RoleDAO();
	$admin = $userDAO->getUserByID($adminID);
	$user = $userDAO->getUserByID($userID);
	$role = $roleDAO->getRoleByID($roleID);
	
	if($user === null)
		return "User: ".$userID." doesn't exist!";
	if($role === null)
		return "Role: ".$userID." doesn't exist!";
	if($admin->getRole()->getRoleID() == 0 || $admin->getRole()->getRoleID() == 3)
		return "You do not have the right to change user role!";
	if($user->getRole()->getRoleID() === $roleID) {
		return "The role has already been set!";
	}
	if($admin->getRoleID() == 1) {
		$user->setRole($role);
		$userDAO->updateUser($user);
	}
	if($admin->getRole()->getRoleID() == 2) {
		if($roleID == 1 || $roleID() == 2)
			return "You do not have the right to change user role!";
		
		$user->setRole($role);
		$userDAO->updateUser($user);
		echo "<br>You have successfully changed ".$user->getUsername()."\'s role to ".$role->getRoleName();
	}
}
function changeUserPassword($userID, $password) {
	$userDAO = new UserDAO();
	$user = $userDAO->getUserByID($userID);
	
	if(!isValidPassword($password))
		return "Invalid password!";
	if($user->getRole()->getRoleID() == 0)
		return "You do not have right to change it!";
	
	$user->setPassword($password);
	$userDAO = new UserDAO();
	$userDAO->updateUser($user);
	echo "<br>You have successfully changed ".$user->getUsername()."\'s password!";
}
function changeUserDepartment($userID, $departmentID) {
	$userDAO = new UserDAO();
	$departmentDAO = new DepartmentDAO();
	$user = $userDAO->getUserByID($userID);
	$department = $departmentDAO->getDepartmentByID($departmentID);
	
	if($department === null)
		return "Department: ".$departmentID." doesn't exist!";
	
	if($user->getRole()->getRoleID() == 1 || $user->getRole()->getRoleID() == 2) {
		$user->setDepartment($dept);
		$userDAO->updateUser($user);
		echo "<br>You have successfully changed ".$user->getUsername()."\'s role to ".$department->getDepartmentName();		
	}
}
function changeUserFirstName($userID, $firstname) {
	$userDAO = new UserDAO();
	$user = $userDAO->getUserByID($userID);
	
	if(!isValidName($firstname))
		return "Invalid first name!";
	
	$user->setFirstName($firstname);
	$userDAO->updateUser($user);
	echo "<br>You have successfully changed ".$user->getUsername()."\'s first name to ".$user->getFirstName();
}
function changeUserLastName($userID, $lastname) {
	$userDAO = new UserDAO();
	$user = $userDAO->getUserByID($userID);
	
	if(!isValidName($lastname))
		return "Invalid last name!";
	
	$user->setLastName($lastname);
	$userDAO->updateUser($user);
	echo "<br>You have successfully changed ".$user->getUsername()."\'s last name to ".$user->getLastName();
}
function changeUserGender($userID, $gender) {
	$userDAO = new UserDAO();
	$user = $userDAO->getUserByID($userID);
	
	if($gender !== 1 && $gender !== 2){
		return "Please select Male or Female!";
	}
	$user->setGender($gender);
	$userDAO->updateUser($user);
	echo "<br>You have successfully changed ".$user->getUsername()."\'s gender to ".$user->getGender();
}
function changeUserProfile($userID, $departmentID, $firstname, $lastname, $gender) {
	$userDAO = new UserDAO();
	$departmentDAO = new DepartmentDAO();
	$user = $userDAO->getUserByID($userID);
	$department = $departmentDAO->getDepartmentByID($departmentID);
	
	if(!isValidID($userID) || !isValidID($departmentID))
		return "Invalid ID!";
	
	if($department === null)
		return "Department: ".$departmentID." doesn't exist!";
	
		$user->setDepartment($dept);
	
	if(!isValidName($firstname))
		return "Invalid first name!";
	
	$user->setFirstName($firstname);
		
	if(!isValidName($lastname))
		return "Invalid last name!";
	
	$user->setLastName($lastname);
	
	if($gender !== 0 && $gender !== 1)
		return "Please select Male or Female!";
	
	$user->setGender($gender);
	
	$userDAO->updateUser($user);	
}
function addDepartment($adminID, $parentDepartmentID, $departmentName) {
	$userDAO = new UserDAO();
	$admin = $userDAO->getUserByID($adminID);
	if($admin->getRole()->getRoleID !== 1 || $admin->getRole()->getRoleID !== 2)
		return "You do not have the right to add department!";
	$departmentDAO = new DepartmentDAO();
	$parentDepartment = $departmentDAO->getDepartmentByID($parentDepartmentID);
	if($parentDepartment === null)
		return "Invalid parent department!";
	
	$department = new Department($parentDepartment, $departmentName);
	$departmentDAO->insertDepartment($department);
}
function deleteDepartment($adminID, $departmentID) {
	$userDAO = new UserDAO();
	$admin = $userDAO->getUserByID($adminID);
	if($admin->getRole()->getRoleID !== 1 || $admin->getRole()->getRoleID !== 2)
		return "You do not have the right to add department!";
	$departmentDAO = new DepartmentDAO();
	$departmentDAO->deleteDepartmentByID($departmentID);//need function	
}
function maintainDepartment($adminID, $departmentID, $newDepartmentName) {
	$userDAO = new UserDAO();
	$admin = $userDAO->getUserByID($adminID);
	if($admin->getRole()->getRoleID !== 1 || $admin->getRole()->getRoleID !== 2)
		return "You do not have the right to add department!";
	$departmentDAO = new DepartmentDAO();
	$department = $departmentDAO->getDepartmentByID($departmentID);
	$department->setDepartmentName($newDepartmentName);
	$departmentDAO->updateDepartment($department);//need function
}
function changeGroupStatus($adminID, $groupID, $activateStatus) {
	$userDAO = new UserDAO();
	$admin = $userDAO->getUserByID($adminID);
	if($admin->getRole()->getRoleID !== 1 || $admin->getRole()->getRoleID !== 2)
		return "You do not have the right to change group status!";
	$groupDAO = new GroupDAO();
	$group = $groupDAO->getGroupByID($groupID);//need function
	if($group->getActivateStatus() === $actuvateStatus)
		return "Same Status, no need to change it!";
	$group->setActivateStatus($activateStatis);
	$groupDAO->updateGroup($group);//need function
}
function changeRecordStatus($adminID, $recordID, $displayStatus) {
	$userDAO = new UserDAO();
	$admin = $userDAO->getUserByID($adminID);
	if($admin->getRole()->getRoleID !== 1 || $admin->getRole()->getRoleID !== 2)
		return "You do not have the right to change record status!";
	$recordDAO = new RecordDAO();
	$record = $recordDAO->getRecordByID($recordID);//need function
	if($record->getDisplayStatus() === $displayStatus)
		return "Same Status, no need to change it!";
	$record->setDisplayStatus($displayStatus);
	$recordDAO->updateRecord($record);//need function
}


?>