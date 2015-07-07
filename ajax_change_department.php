<?php
require_once("libraries/head.php");

if (!isLogin())
    sendAjaxRedirect("login.php");

if (isset($_POST["parentid"]) && isset($_POST["departmentname"])) {
    $result = execCreateDep($_SESSION["userID"], $_POST["parentid"], $_POST["departmentname"]);
    if ($result === true)
        sendAjaxResSuc();
    else
        sendAjaxResErr($result);  
} elseif (isset($_POST["departmentid"]) && isset($_POST["departmentname"])) {
    $result = execEditDep($_SESSION["userID"], $_POST["departmentid"], $_POST["departmentname"]);
    if ($result === true)
        sendAjaxResSuc();
    else
        sendAjaxResErr($result);
}

function execCreateDep($userID, $parentID, $departmentName) {
    if (!isValidID($parentID))
        return "Invalid parent ID!";
    if (!isValidDepartmentName($departmentName))
        return "Invalid department name!";
    
    $departDAO = new DepartmentDAO();
    $parent = $departDAO->getDepartmentByID($parentID);
    
    if ($parent === null)
        return "Could not find this parent department!";
    
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    
    $role = $user->getRole();
    if ($role->getRoleID() == "4" || $role->getRoleID() == "3")
        return "You have no right to do this!";
    
    $depart = new Department($parentID, $departmentName);
    $departDAO->insertDepartment($depart);
    return true;
}

function execEditDep($userID, $departmentID, $departmentName) {
    if (!isValidID($departmentID))
        return "Invalid parent ID!";
    if (!isValidDepartmentName($departmentName))
        return "Invalid department name!";
    
    $departDAO = new DepartmentDAO();
    $depart = $departDAO->getDepartmentByID($departmentID);
    
    if ($depart === null)
        return "Could not find this department!";
    
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    
    $role = $user->getRole();
    if ($role->getRoleID() == "4" || $role->getRoleID() == "3")
        return "You have no right to do this!";
    
    $depart->setDepartmentName($departmentName);
    
    $departDAO->updateDepartment($depart);
    return true;
}


function isValidDepartmentName($name) {
	if(strlen($name) < 2 || 
	   strlen($name) > 40 ||
	   preg_match('/[^A-Za-z\' ]/', $name) === 1)
	   return false;
	else
		return true;
}
?>