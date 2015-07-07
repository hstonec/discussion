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