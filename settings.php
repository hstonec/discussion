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
                       "body" => "settings/body.html",
                       "web_nav" => "web_nav.html",
                       "web_footer" => "web_footer.html"));
    $userDAO = new UserDAO();
	$user = $userDAO->getUserByID($_SESSION["userID"]);
	
	//display profile
	displayProfile($user, $tpl);
	
    //display group
    displayGroup($user, $tpl);
    
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
		
}

function displayGroup($user, $tpl) {
    $tpl->define(array("group" => "settings/group.html",
                       "group_tr" => "settings/group_tr.html",
                       "group_td" => "settings/group_td.html",
                       "group_delete" => "settings/group_delete.html"));
    
    $roleID = $user->getRole()->getRoleID();
    $groupDAO = new GroupDAO();
    if ($roleID === "1" || $roleID === "2") {
        $tpl->parse("SETTINGS_GROUP_TD_DELETE", "group_delete");
        $groups = $groupDAO->getAllGroups();
    } elseif ($roleID === "3") {
        $tpl->assign("SETTINGS_GROUP_TD_DELETE", "");
        $groups = $groupDAO->getGroupsByOwner($user);
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
            $tpl->parse("SETTINGS_GROUP_TD", "group_td");
            $tpl->assign("SETTINGS_GROUP_TR_GROUPNAME", $group->getGroupName());
            $tpl->assign("SETTINGS_GROUP_TR_USERNAME", $group->getOwner()->getUsername());
            $tpl->parse("SETTINGS_GROUP_TR", ".group_tr");
        }
    }
    $tpl->parse("SETTINGS_GROUP", "group");
}


?>