<?php
require_once("libraries/head.php");
require_once("libraries/class.FastTemplate.php");


if (!isLogin())
    forward("login.php");

displaySettings();

function displaySettings() {
    $tpl = new FastTemplate("templates/");
    $tpl->define(array("web_main" => "web_main.html",
                       "web_header" => "web_header.html",
                       "head_script" => "settings/head_script.html",
					   "profile" => "settings/profile.html",
                       "department" => "settings/department.html",
                       "department_option" => "settings/department_option.html",
                       "body" => "settings/body.html",
                       "web_nav" => "web_nav.html",
                       "web_footer" => "web_footer.html"));
    $userDAO = new UserDAO();
	$user = $userDAO->getUserByID($_SESSION["userID"]);
	
	//display profile
	displayProfile($user, $tpl);
	
    //display group
    displayGroup($user, $tpl);
    
    //display user
    displayUser($user, $tpl);
    
    desplayDepartment($user, $tpl);
    
    $tpl->assign("TITLE", "My Profile");
    $tpl->parse("WEB_HEADER", "web_header");
    $tpl->parse("HEAD_SCRIPT", "head_script");
    $tpl->parse("WEB_NAV", "web_nav");
	$tpl->parse("SETTINGS_PROFILE", "profile");
    $tpl->parse("BODY", ".body");
    $tpl->parse("WEB_FOOTER", "web_footer");
    $tpl->parse("MAIN", "web_main");
    $tpl->FastPrint();
}

function displayProfile($user, $tpl) {
	$tpl->assign("SETTINGS_PROFILE_FIRST", $user->getFirstName());
	$tpl->assign("SETTINGS_PROFILE_LAST", $user->getLastName());
	$tpl->assign("SETTINGS_PROFILE_USERNAME", $user->getUsername());
	$gender = $user->getGender();
	if ($gender === "1") {
		$tpl->assign("SETTINGS_PROFILE_MALE", "checked");
		$tpl->assign("SETTINGS_PROFILE_FEMALE", "");
	} elseif ($gender === "2") {
		$tpl->assign("SETTINGS_PROFILE_MALE", "");
		$tpl->assign("SETTINGS_PROFILE_FEMALE", "checked");
	}
    
    $departDAO = new DepartmentDAO();
    $departs = $departDAO->getAllDepartments();
    if ($departs === null)
        $tpl->assign("SETTINGS_DEPARTMENT_OPTION_PROFILE", "");
    else{
        foreach ($departs as $depart) {
            if ($user->getDepartment()->getDepartmentID() === $depart->getDepartmentID()) {
                if ($depart->getDepartmentID() === "1")
                    $tpl->assign("SETTINGS_DEPARTMENT_ROOT", "selected");
                else {
                    $tpl->assign("SETTINGS_DEPARTMENT_ROOT", "");
                    $tpl->assign("SETTINGS_DEPARTMENT_SELECTED", "selected");
                }
            } else {
                $tpl->assign("SETTINGS_DEPARTMENT_SELECTED", "");
            }
            if ($depart->getDepartmentID() === "1")
                continue;
            $tpl->assign("SETTINGS_DEPARTMENT_DEPARTID", $depart->getDepartmentID());
            $tpl->assign("SETTINGS_DEPARTMENT_DEPARTNAME", $depart->getDepartmentName());
            $tpl->parse("SETTINGS_DEPARTMENT_OPTION_PROFILE", ".department_option");
        }
    }
		
}

function displayGroup($user, $tpl) {
    $tpl->define(array("group" => "settings/group.html",
                       "group_tr" => "settings/group_tr.html",
                       "group_td" => "settings/group_td.html",
                       "group_delete" => "settings/group_delete.html"));
    
    $roleID = $user->getRole()->getRoleID();
    $groupDAO = new GroupDAO();
    if ($roleID === "1" || $roleID === "2") {
        $groups = $groupDAO->getAllGroups();
        $tpl->parse("SETTINGS_GROUP_TD_DELETE", "group_delete");
    } elseif ($roleID === "3") {
        $groups = $groupDAO->getGroupsByOwner($user);
        $tpl->assign("SETTINGS_GROUP_TD_DELETE", "");
    }
    if ($groups === null) {
        $tpl->assign("SETTINGS_GROUP_TR", "");
    } else {
        foreach ($groups as $group) {
            $currentStatus = $group->getActivateStatus(); 
            if ($currentStatus == "1") {
                $tpl->assign("SETTINGS_GROUP_TD_CURR_NAME", "Activated");
                $tpl->assign("SETTINGS_GROUP_TD_CHAN_STATUS", "2");
                $tpl->assign("SETTINGS_GROUP_TD_CHAN_NAME", "Block");
            } elseif ($currentStatus == "2") {
                $tpl->assign("SETTINGS_GROUP_TD_CURR_NAME", "Blocked");
                $tpl->assign("SETTINGS_GROUP_TD_CHAN_STATUS", "1");
                $tpl->assign("SETTINGS_GROUP_TD_CHAN_NAME", "Activate");
            }
            $tpl->assign("SETTINGS_GROUP_GROUPID", $group->getGroupID());
            $tpl->parse("SETTINGS_GROUP_TD", "group_td");
            $tpl->assign("SETTINGS_GROUP_TR_GROUPNAME", $group->getGroupName());
            $tpl->assign("SETTINGS_GROUP_TR_USERNAME", $group->getOwner()->getUsername());
            $tpl->parse("SETTINGS_GROUP_TR", ".group_tr");
        }
    }
    $tpl->parse("SETTINGS_GROUP", "group");
}

function displayUser($user, $tpl){
    $tpl->define(array("user" => "settings/user.html",
                       "user_tr" => "settings/user_tr.html",
                       "user_role" => "settings/user_role.html",
                       "user_root" => "settings/user_root.html"));
    $roleID = $user->getRole()->getRoleID();
    $userDAO = new UserDAO();
     
    if ($roleID === "1") {
        $tpl->parse("SETTINGS_USER_TD_ROOT", "user_root");
        $roleUsers1 = $userDAO->getUsersByRoleID("1");
        changRole($tpl, $roleUsers1, "1");
    
        $roleUsers2 = $userDAO->getUsersByRoleID("2");
        changRole($tpl, $roleUsers2, "2");
        
        $roleUsers3 = $userDAO->getUsersByRoleID("3");
        changRole($tpl, $roleUsers3, "3");
        
        $roleUsers4 = $userDAO->getUsersByRoleID("4");
        changRole($tpl, $roleUsers4, "4");
    } elseif ($roleID === "2") {
        $tpl->assign("SETTINGS_USER_TD_ROOT", "");
        $roleUsers3 = $userDAO->getUsersByRoleID("3");
        if ($roleUsers3 === null)
            $tpl->assign("SETTINGS_USER_TR", "");
        changRole($tpl, $roleUsers3, "3");
        $roleUsers4 = $userDAO->getUsersByRoleID("4");
        if ($roleUsers4 === null)
            $tpl->assign("SETTINGS_USER_TR", "");
        changRole($tpl, $roleUsers4, "4");
        
    }
    $tpl->parse("SETTINGS_USER", "user");
}
function changRole($tpl, $roleUsers, $idRole){ 
    //show users of role=1
    if ($roleUsers !== null) {
        foreach ($roleUsers as $r){
            if ($idRole === "1"){
                $tpl->assign("SETTINGS_USER_TD_CURR_ROLE_STATUS", "Root");
                $tpl->assign("SETTING_USER_TD_USERID", $r->getUserID());
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_STATUS1","3");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_NAME1","User");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_STATUS2","4");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_NAME2","Forbidden");
            }
            elseif ($idRole === "2"){
                $tpl->assign("SETTINGS_USER_TD_CURR_ROLE_STATUS", "Administrator");
                $tpl->assign("SETTING_USER_TD_USERID", $r->getUserID());
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_STATUS1","3");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_NAME1","User");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_STATUS2","4");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_NAME2","Forbidden");
            }
            elseif ($idRole === "3") {
                $tpl->assign("SETTINGS_USER_TD_CURR_ROLE_STATUS", "User");
                $tpl->assign("SETTING_USER_TD_USERID", $r->getUserID());
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_STATUS1","3");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_NAME1","User");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_STATUS2","4");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_NAME2","Forbidden");
            }
            elseif ($idRole === "4") {
                $tpl->assign("SETTINGS_USER_TD_CURR_ROLE_STATUS", "Forbidden");
                $tpl->assign("SETTING_USER_TD_USERID", $r->getUserID());
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_STATUS1","3");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_NAME1","User");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_STATUS2","4");
                $tpl->assign("SETTINGS_USER_TD_CHAN_ROLE_NAME2","Forbidden");
            }
            $tpl->parse("SETTINGS_USER_TD_ROLE", "user_role");
            $tpl->assign("SETTINGS_USER_TD_FIRSTNAME", $r->getFirstName());
            $tpl->assign("SETTINGS_USER_TD_LASTNAME", $r->getLastName());
            $gender = $r->getGender();
            if ($gender === "1")
                $gender = "Male";
            elseif ($gender === "2")
                $gender = "Female";
            $tpl->assign("SETTINGS_USER_TD_GENDER", $gender);
            $tpl->parse("SETTINGS_USER_TR", ".user_tr");
        }
      }
    
}

function desplayDepartment($user, $tpl) {

    $departDAO = new DepartmentDAO();
    $departs = $departDAO->getAllDepartments();
    if ($departs === null)
        $tpl->assign("SETTINGS_DEPARTMENT_OPTION", "");
    else{
        foreach ($departs as $depart) {
            if ($depart->getDepartmentID() === "1")
                continue;
            $tpl->assign("SETTINGS_DEPARTMENT_DEPARTID", $depart->getDepartmentID());
            $tpl->assign("SETTINGS_DEPARTMENT_DEPARTNAME", $depart->getDepartmentName());
            $tpl->parse("SETTINGS_DEPARTMENT_OPTION", ".department_option");
        }
    }
    $tpl->parse("SETTINGS_DEPARTMENT", "department");
}

?>