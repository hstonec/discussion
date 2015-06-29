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
	   preg_match('/[^A-Za-z0-9]/', $name) === 1)
	   return false;
	else
		return true;
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
	}
}
function changeUserPassword($userID, $password) {
	$userDAO = new UserDAO();
	$user = $userDAO->getUserByID($userID);
	
	if(!isValidPassword($password))
		return "Invalid password!";
	if(user->getRole()->getRoleID() == 0)
		return "You do not have right to change it!";
	
	$user->setPassword($password);
	$userDAO = new UserDAO();
	$userDAO->updateUser($user);
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
	}
}
function changeUserFirstName($userID, $firstname) {
	$userDAO = new UserDAO();
	$user = $userDAO->getUserByID($userID);
	
	if(!isValidName($firstname))
		return "Invalid first name!";
	
	$user->setFirstName($firstname);
	$userDAO->updateUser($user);
}
function changeUserLastName($userID, $lastname) {
	$userDAO = new UserDAO();
	$user = $userDAO->getUserByID($userID);
	
	if(!isValidName($lastname))
		return "Invalid last name!";
	
	$user->setLastName($lastname);
	$userDAO->updateUser($user);
}
function changeUserGender($userID, $gender) {
	$userDAO = new UserDAO();
	$user = $userDAO->getUserByID($userID);
	
	if($gender !== 0 || $gender !== 1)
		return "Please select Male or Female!";
	
	$user->setGender($gender);
	$userDAO->updateUser($user);
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
	
	if($gender !== 0 || $gender !== 1)
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
	$departmentDAO->deleteDepartmentByID($departmentID);	
}
function maintainDepartment($adminID, $departmentID, $newDepartmentName) {
	$userDAO = new UserDAO();
	$admin = $userDAO->getUserByID($adminID);
	if($admin->getRole()->getRoleID !== 1 || $admin->getRole()->getRoleID !== 2)
		return "You do not have the right to add department!";
	$departmentDAO = new DepartmentDAO();
	$department = $departmentDAO->getDepartmentByID($departmentID);
	$department->setDepartmentName($newDepartmentName);
	$departmentDAO->updateDepartment($department);//⊿Τ硂ㄧ计
}
function changeGroupStatus($adminID, $groupID, $activateStatus) {
	$userDAO = new UserDAO();
	$admin = $userDAO->getUserByID($adminID);
	if($admin->getRole()->getRoleID !== 1 || $admin->getRole()->getRoleID !== 2)
		return "You do not have the right to change group status!";
	$groupDAO = new GroupDAO();
	$group = $groupDAO->getGroupByID($groupID);//⊿Τ硂ㄧ计
	if($group->getActivateStatus() === $actuvateStatus)
		return "Same Status, no need to change it!";
	$group->setActivateStatus($activateStatis);
	$groupDAO->updateGroup($group);//⊿Τ硂ㄧ计
}
function changeRecordStatus($adminID, $recordID, $displayStatus) {
	$userDAO = new UserDAO();
	$admin = $userDAO->getUserByID($adminID);
	if($admin->getRole()->getRoleID !== 1 || $admin->getRole()->getRoleID !== 2)
		return "You do not have the right to change record status!";
	$recordDAO = new RecordDAO();
	$record = $recordDAO->getRecordByID($recordID);//⊿Τ硂ㄧ计
	if($record->getDisplayStatus() === $displayStatus)
		return "Same Status, no need to change it!";
	$record->setDisplayStatus($displayStatus);
	$recordDAO->updateRecord($record);//⊿Τ硂ㄧ计
}

?>