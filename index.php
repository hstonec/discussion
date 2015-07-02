<?php
require_once("libraries/head.php");
require_once("libraries/class.FastTemplate.php");


if (!isLogin())
    forward("login.php");

//displayIndex();
temp();

function temp() {
    $tpl = new FastTemplate("templates/");
    $tpl->define(array("web_main" => "web_main.html",
                       "web_header" => "web_header.html",
                       "head_script" => "index/head_script.html",
                       "body" => "index/body.html",
                       "web_nav" => "web_nav.html",
                       "web_footer" => "web_footer.html"));
    
    $tpl->assign("TITLE", "Home");
    $tpl->parse("WEB_HEADER", "web_header");
    $tpl->parse("HEAD_SCRIPT", "head_script");
    $tpl->parse("WEB_NAV", "web_nav");
    $tpl->parse("BODY", ".body");
    $tpl->parse("WEB_FOOTER", "web_footer");
    $tpl->parse("MAIN", "web_main");
    $tpl->FastPrint();
}

function displayIndex() {
    $tpl = new FastTemplate("templates/");
    $tpl->define(array("main" => "index/main.html",
                       "rootul" => "index/rootul.html",
                       "li" => "index/li.html",
                       "liul" => "index/liul.html",
                       "groupul" => "index/groupul.html",
                       "groupli" => "index/groupli.html",
                       "grouptab" => "index/grouptab.html"));
    $userDAO = new UserDAO();
    $loginUser = $userDAO->getUserByID($_SESSION["userID"]);
    
    //display root department and user
    $deptDAO = new DepartmentDAO();
    $rootDepart = $deptDAO->getDepartmentByID(1);
    //find user belonged to the root
    $users = $userDAO->getUsersByDepartment($rootDepart);
    if ($users !== null) {
        foreach ($users as $user) {
            //ignore myself
            if ($user->getUserID() == $loginUser->getUserID())
                continue;
            $tpl->assign("INDEX_USERID", (string)$user->getUserID());
            $tpl->assign("INDEX_USERNAME", $user->getFirstName()." ".$user->getLastName());
            $tpl->parse("INDEX_ROOTLI", ".li");
        }
    }
    //find department belonged to the root
    $childsDepart = $deptDAO->getChildDepartments($rootDepart);
    if ($childsDepart !== null) {
        foreach ($childsDepart as $depart) {
            //ignore root folder
            if ($depart->getDepartmentID() === $depart->getParentID())
                continue;
            $tpl->assign("INDEX_DEPTNAME", $depart->getDepartmentName());
            $tpl->parse("INDEX_ROOTLI", ".liul");
        }
    }
    $tpl->parse("INDEX_DEPART", "rootul");
    
    //display groups which belongs to this user
    $gmDAO = new GroupMemberDAO();
    $groupMembers = $gmDAO->getGroupMembersByUser($loginUser);
    if ($groupMembers !== null)
        foreach ($groupMembers as $gm) {
            //display group ul
            $group = $gm->getGroup();
            $tpl->assign("INDEX_GROUPID", $group->getGroupID());
            $tpl->assign("INDEX_GROUPNAME", $group->getGroupName());
            $tpl->parse("INDEX_GROUPLI", ".groupli");
            //display group tab
            $tpl->parse("INDEX_GROUPTAB", ".grouptab");
        }
    else {
        $tpl->assign("INDEX_GROUPLI", "");
        $tpl->assign("INDEX_GROUPTAB", "You didn't have any group!");
    }
        
    $tpl->parse("INDEX_GROUPUL", "groupul");
    
    
    $tpl->assign("INDEX_FIRST", $loginUser->getFirstName());
    
    
    $tpl->parse("MAIN", "main");
    $tpl->FastPrint();
    
}

function postRecord($userID, $groupID, $messageType, $content) {
    if (!isValidID($groupID))
        return "Group id is not valid!";
    if (!isValidMessage($messageType, $content))
        return "Message is not valid!";
    $groupDAO = new GroupDAO();
    $group = $groupDAO->getGroupByID($groupID);
    if ($group === null)
        return "Can not find this group!";
    if (!isGroupActivate($group))
        return "Group is not activated!";
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    $groupMemberDAO = new GroupMemberDAO();
    $groupMember = $groupMemberDAO->getGroupMember($group, $user);
    if ($groupMember === null)
        return "User didn't belong to this group!";
    $record = new Record(
        $group,
        $user,
        $messageType, 
        $content, 
        1
    );
    $recordDAO = new RecordDAO();
    $recordDAO->insertRecord($record);
    
}

function isValidMessage($messageType, $content) {
    //1 text
    //2 link
    //3 img
    //4 file
    return true;
}

function isGroupActivate($group) {
    if ($group->getActivateStatus() === 1)
        return true;
    else
        return false;
}

function getDepartments() {
    $deptDAO = new DepartmentDAO();
    $root = $deptDAO->getDepartmentByID(1);
    return getDeptTree($root, $deptDAO);
}
function getDeptTree($root, $deptDAO) {
    $arr = array("id" => $root->getDepartmentID(),
                 "name" => $root->getDepartmentName());
    $child = $deptDAO->getChildDepartments($root);
    if ($child === null)
        $arr["child"] = false; 
    else {
        $arr["child"] = array();
        foreach ($child as $childDept)
            $arr["child"][] = getDeptTree($root, $deptDAO);
    }
    return $child;
}
?>