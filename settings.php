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


?>