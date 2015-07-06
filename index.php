<?php
require_once("libraries/head.php");
require_once("libraries/class.FastTemplate.php");


if (!isLogin())
    forward("login.php");

//displayIndex();
temp($_SESSION["userID"]);

function temp($userID) {
    $tpl = new FastTemplate("templates/");
    $tpl->define(array("web_main" => "web_main.html",
                       "web_header" => "web_header.html",
                       "head_script" => "index/head_script.html",
                       "user" => "index/user.html",
                       "department" => "index/department.html",
                       "list_item" => "index/list_item.html",
                       "group" => "index/group.html",
                       "comment" => "index/comment.html",
                       "link" => "index/link.html",
                       "image" => "index/image.html",
                       "body" => "index/body.html",
                       "web_nav" => "web_nav.html",
                       "web_footer" => "web_footer.html"));
    
    
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    
    
    //initial list item
    $gmDAO = new GroupMemberDAO();
    $gms = $gmDAO->getGroupMembersByUser($user);
    if ($gms !== null) {
        $i = 1;
        foreach($gms as $gm) {
            if ($gm->getAcceptStatus() == "2")
                continue;
            $group = $gm->getGroup();
            $tpl->assign("INDEX_LIST_ITEM_GROUPID", $group->getGroupID());
            if ($i == 1) {
                $tpl->assign("INDEX_GROUP_HEADER", $group->getGroupName());
                $tpl->assign("INDEX_LIST_ITEM_ACTIVE", "active");
            } else
                $tpl->assign("INDEX_LIST_ITEM_ACTIVE", "");
            $tpl->assign("INDEX_LIST_ITEM_SEQ", $i);
            $tpl->assign("INDEX_LIST_ITEM_GROUPNAME", $group->getGroupName());
            $tpl->parse("INDEX_LIST_ITEM_LI", ".list_item");
            
            $i++;
        }
    } else
        $tpl->assign("INDEX_LIST_ITEM_LI", "");
    
    //initial comments
    $recordDAO = new RecordDAO();
    
    if ($gms !== null) {
        $i = 1;
        foreach($gms as $gm) {
            if ($gm->getAcceptStatus() == "2")
                continue;
            $group = $gm->getGroup();
            if ($i == 1) {
                $tpl->assign("INDEX_GROUP_HIDE", "");
            } else
                $tpl->assign("INDEX_GROUP_HIDE", "hide");
            $tpl->assign("INDEX_GROUP_SEQ", $i);
            
            $records = $recordDAO->getRecordsByGroup($group);
            if ($records === null) {
                $tpl->assign("INDEX_GROUP_COMMENT", "");
            } else {
                $tpl->clear("INDEX_GROUP_COMMENT");
                foreach($records as $rec) {
                    if ($rec->getDisplayStatus() === "2")
                        continue;
                    $commentUser = $rec->getUser();
                    $tpl->assign("INDEX_GROUP_COMMENT_USERPHOTO", $commentUser->getPhotoURL());
                    $tpl->assign("INDEX_GROUP_COMMENT_USERNAME", $commentUser->getFirstName()." ".$commentUser->getLastName());
                        
                    $tpl->assign("INDEX_GROUP_COMMENT_TIME", $rec->getTime());        
                    $tpl->assign("INDEX_GROUP_COMMENT_CONTENT", $rec->getContent());
                    $tpl->parse("INDEX_GROUP_COMMENT", ".comment");
                }
            }
            $tpl->parse("INDEX_GROUP", ".group");
            $i++;
        }
    } else {
        $tpl->assign("INDEX_GROUP_COMMENT", "");
        $tpl->parse("INDEX_GROUP", "group");
    }
    

    //initial department and user
    $result = findDepartAndUser(1, $userID);
    if (count($result) === 0)
        $tpl->assign("INDEX_DEPART_USER", "");
    else {
        foreach($result as $node) {
            if ($node["type"] == 1) {
                $tpl->assign("INDEX_DEPARTID", $node["id"]);
                $tpl->assign("INDEX_DEPART_NAME", $node["name"]);
                $tpl->parse("INDEX_DEPART_USER", ".department");
            } elseif ($node["type"] == 2) {
                $tpl->assign("INDEX_USERID", $node["id"]);
                $tpl->assign("INDEX_USER_NAME", $node["name"]);
                $tpl->parse("INDEX_DEPART_USER", ".user");
            }
        }
    }
    
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