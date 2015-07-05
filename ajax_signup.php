<?php
require_once("libraries/head.php");

if (isLogin())
    sendAjaxRedirect("index.php");

if (isset($_POST["username"]) && 
    isset($_POST["password"]) &&
    isset($_POST["confirmpw"]) &&
    isset($_POST["firstname"]) &&
    isset($_POST["lastname"]) &&
    isset($_POST["gender"])) {
    $result = execSignup($_POST["username"], 
                         $_POST["password"],
                         $_POST["confirmpw"],
                         $_POST["firstname"],
                         $_POST["lastname"],
                         $_POST["gender"]);
    if ($result === true)
        sendAjaxResSuc();
    else
        sendAjaxResErr($result);
}

function execSignup($username,
                    $password,
                    $confirmpw,
                    $firstname,
                    $lastname,
                    $gender) {
    if ($username == "" || !isValidUsername($username))
        return "Username is empty or invalid!";
    if ($password == "" || !isValidPassword($password))
        return "Password is empty or invalid!";
    if ($confirmpw == "" || !isValidPassword($confirmpw))
        return "Confirm Password is empty or invalid!";
    if ($firstname == "" || !isValidName($firstname))
        return "First Name is empty or invalid!";
    if ($lastname == "" || !isValidName($lastname))
        return "Last Name is empty or invalid!";
    if ($gender == "" || !isValidGender($gender))
        return "Gender is empty or invalid!";
    
    $userDAO = new UserDAO();
    
    //verify username exist
    $result = $userDAO->getUserByUsername($username);
    if ($result !== null)
        return "Username exists, please change to another one!";
    
    //verify $password == $confirmpw
    if ($password != $confirmpw)
        return "Password and Confirm Password must be same!";
    
    $roleDAO = new RoleDAO();
    $role = $roleDAO->getRoleByID(3); //normal user
    
    $departmentDAO = new DepartmentDAO();
    $depart = $departmentDAO->getDepartmentByID(1); //root department
    
    $encryptPW = encryptPassword($password);
    $photoURL = "photo/default.png";
    $user = new User($role,
                     $depart,
                     $username,
                     $encryptPW,
                     $firstname,
                     $lastname,
                     $gender,
                     $photoURL);
    if ($userDAO->insertUser($user) === true)
        return true;
    else
        return "Insert user into table error, please contact administrator!";
}

?>